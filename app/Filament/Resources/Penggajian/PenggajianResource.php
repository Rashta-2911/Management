<?php

namespace App\Filament\Resources\Penggajian;

use App\Filament\Resources\Penggajian\Pages\CreatePenggajian;
use App\Filament\Resources\Penggajian\Pages\EditPenggajian;
use App\Filament\Resources\Penggajian\Pages\ListPenggajian;
use App\Filament\Resources\Penggajian\Pages\ViewPenggajian;
use App\Filament\Resources\Penggajian\Schemas\PenggajianForm;
use App\Filament\Resources\Penggajian\Schemas\PenggajianInfolist;
use App\Filament\Resources\Penggajian\Tables\PenggajianTable;
use App\Filament\Traits\HasPropertiAktifScope;
use App\Models\Penggajian;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Override;

class PenggajianResource extends Resource
{
    use HasPropertiAktifScope;

    protected static ?string $model = Penggajian::class;

    protected static ?string $pluralLabel = 'Penggajian';

    protected static ?string $slug = 'penggajian';

    protected static ?string $title = 'Data Penggajian';

    protected static string|\UnitEnum|null $navigationGroup = 'Kepegawaian';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PenggajianForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenggajianTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PenggajianInfolist::configure($schema);
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
            'index' => ListPenggajian::route('/'),
            'create' => CreatePenggajian::route('/create'),
            'edit' => EditPenggajian::route('/{record}'),
            'view' => ViewPenggajian::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return static::applyPropertiAktifScope(
            parent::getRecordRouteBindingEloquentQuery()->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]),
            'karyawan.properti_id'
        );
    }

    public static function getEloquentQuery(): Builder
    {
        return static::applyPropertiAktifScope(
            parent::getEloquentQuery(),
            'karyawan.properti_id'
        );
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
        return Auth::user()?->hasAnyRole(['pemilik']) ?? false;
    }
}
