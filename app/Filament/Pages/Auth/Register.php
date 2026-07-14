<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),

                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function handleRegistration(array $data): User
    {
        $user = parent::handleRegistration($data);

        $user->assignRole('pemilik');

        return $user;
    }

    public function getSubheading(): HtmlString|string|null
    {
        return new HtmlString(
            '<a href="' . url('/login') . '"
                class="inline-flex items-center gap-1 text-sm
                    text-gray-500 hover:text-gray-700
                    transition-colors duration-200">
                ← Kembali ke Login
            </a>'
        );
    }
}