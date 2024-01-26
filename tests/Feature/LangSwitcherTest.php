<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LangSwitcherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_switch_en_lang()
    {
        $user = $this->loginAsUser();

        $this->visitRoute('profile.show');
        $this->seeElement('button', ['ms' => 'lang_en']);

        $this->press('lang_en');

        $this->seeInSession('lang', 'en');
    }

    /** @test */
    public function user_can_switch_ms_lang()
    {
        $user = $this->loginAsUser();

        $this->visitRoute('profile.show');
        $this->seeElement('button', ['ms' => 'lang_ms']);

        $this->press('lang_ms');

        $this->seeInSession('lang', 'ms');
    }
}
