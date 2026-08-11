<?php

namespace App\Filament\Resources\Penghuni;

use App\Filament\Resources\Penghuni\Pages\CreatePenghuni;
use App\Filament\Resources\Penghuni\Pages\EditPenghuni;
use App\Filament\Resources\Penghuni\Pages\ListPenghuni;
use App\Filament\Resources\Penghuni\Pages\ViewPenghuni;
use App\Filament\Resources\Penghuni\Schemas\PenghuniForm;
use App\Filament\Resources\Penghuni\Schemas\PenghuniInfolist;
use App\Filament\Resources\Penghuni\Tables\PenghuniTable;
use App\Filament\Traits\HasPropertiAktifScope;
use App\Models\Penghuni;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenghuniResource extends Resource
{
    use HasPropertiAktifScope;

    protected static ?string $model = Penghuni::class;

    protected static ?string $slug = 'penghuni';

    protected static ?string $navigationLabel = 'Penghuni';

    protected static ?string $pluralLabel = 'Penghuni';

    protected static ?string $modelLabel = 'Penghuni';

    protected static string|\UnitEnum|null $navigationGroup = 'Kelola Penghuni';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'nama_penghuni';

    public static function infolist(Schema $schema): Schema
    {
        return PenghuniInfolist::configure($schema);
    }

    public static function form(Schema $schema): Schema
    {
        return PenghuniForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenghuniTable::configure($table);
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
            'index' => ListPenghuni::route('/'),
            'create' => CreatePenghuni::route('/create'),
            'view' => ViewPenghuni::route('/{record}'),
            'edit' => EditPenghuni::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return static::applyPropertiAktifScope(
            parent::getRecordRouteBindingEloquentQuery()->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]),
            'kamar.tipeKamar.properti_id'
        );
    }

    public static function getEloquentQuery(): Builder
    {
        return static::applyPropertiAktifScope(
            parent::getEloquentQuery(),
            'kamar.tipeKamar.properti_id'
        );
    }
}
