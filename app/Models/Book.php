<?php

namespace App\Models;

use App\Models\BankAccount;
use App\Models\Category;
use App\Traits\Models\ConstantsGetter;
use App\Transaction;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use ConstantsGetter;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const REPORT_VISIBILITY_PUBLIC = 'public';
    const REPORT_VISIBILITY_INTERNAL = 'internal';
    const REPORT_PERIODE_IN_MONTHS = 'in_months';
    const REPORT_PERIODE_IN_WEEKS = 'in_weeks';
    const REPORT_PERIODE_ALL_TIME = 'all_time';

    protected $fillable = [
        'name', 'description', 'status_id', 'creator_id', 'bank_account_id', 'report_visibility_code', 'report_titles',
        'budget', 'report_periode_code', 'start_week_day_code',
    ];
    protected $casts = [
        'report_titles' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => __('app.system')]);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function getNameLabelAttribute()
    {
        return '<span class="badge badge-pill badge-secondary">'.$this->name.'</span>';
    }

    public function getStatusAttribute()
    {
        return $this->status_id == static::STATUS_INACTIVE ? __('app.inactive') : __('app.active');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class)->withDefault(['name' => __('book.no_bank_account')]);
    }

    public function getBalance($perDate = null, $startDate = null, $categoryId = null): float
    {
        $transactionQuery = $this->transactions();
        $transactionQuery->withoutGlobalScope('forActiveBook');
        if ($perDate) {
            $transactionQuery->where('date', '<=', $perDate);
        }
        if ($startDate) {
            $transactionQuery->where('date', '>=', $startDate);
        }
        if ($categoryId) {
            $transactionQuery->where('category_id', $categoryId);
        }
        $transactionQuery->where('book_id', $this->id);
        $transactions = $transactionQuery->get();

        return $transactions->sum(function ($transaction) {
            return $transaction->in_out ? $transaction->amount : -$transaction->amount;
        });
    }

    public function getNonceAttribute()
    {
        return sha1($this->id.config('app.key'));
    }

    public function getCurrentBudget(): float
{
    $currentBalance = 0;
    $startBalance = 0;
    $currentIncomeTotal = 0;
    $currentSpendingTotal = 0;

    $currentTransactions = $this->transactions()
        ->withoutGlobalScope('forActiveBook')
        ->get();
    $currentIncomeTotal = $currentTransactions->where('in_out', 1)->sum('amount');
    $currentSpendingTotal = $currentTransactions->where('in_out', 0)->sum('amount');
    $endOfLastDate = today()->startOfWeek()->subDay()->format('d-m-Y');
    $startBalance = $this->getBalance($endOfLastDate);
    $currentBalance = $startBalance + $currentIncomeTotal - $currentSpendingTotal;

    return $currentBalance;
}

}
