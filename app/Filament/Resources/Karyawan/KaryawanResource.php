<?php

namespace App\Filament\Resources\Karyawan;

use App\Filament\Resources\Karyawan\Pages\CreateKaryawan;
use App\Filament\Resources\Karyawan\Pages\EditKaryawan;
use App\Filament\Resources\Karyawan\Pages\ListKaryawan;
use App\Filament\Resources\Karyawan\Pages\ViewKaryawan;
use App\Filament\Resources\Karyawan\Schemas\KaryawanForm;
use App\Filament\Resources\Karyawan\Schemas\KaryawanInfolist;
use App\Filament\Resources\Karyawan\Tables\KaryawanTable;
use App\Filament\Traits\HasPropertiAktifScope;
use App\Models\Karyawan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Override;

class KaryawanResource extends Resource
{
    use HasPropertiAktifScope;

    protected static ?string $model = Karyawan::class;

    protected static ?string $pluralLabel = 'Karyawan';

    protected static string|\UnitEnum|null $navigationGroup = 'Kepegawaian';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return KaryawanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KaryawanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KaryawanTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKaryawan::route('/'),
            'create' => CreateKaryawan::route('/create'),
            'view' => ViewKaryawan::route('/{record}'),
            'edit' => EditKaryawan::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user !== null && $user->hasAnyRole(['admin', 'pemilik']);
    }

    #[Override]
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->hasRole('pemilik') ?? false;
    }

    public static function getEloquentQuery(): Builder
    {
        return static::applyPropertiAktifScope(
            parent::getEloquentQuery(),
            'properti_id'
        );
    }
}
