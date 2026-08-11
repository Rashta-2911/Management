<?php

namespace App\Filament\Resources\Pembayaran;

use App\Filament\Resources\Pembayaran\Pages\CreatePembayaran;
use App\Filament\Resources\Pembayaran\Pages\EditPembayaran;
use App\Filament\Resources\Pembayaran\Pages\ListPembayaran;
use App\Filament\Resources\Pembayaran\Pages\ViewPembayaran;
use App\Filament\Resources\Pembayaran\Schemas\PembayaranForm;
use App\Filament\Resources\Pembayaran\Schemas\PembayaranInfolist;
use App\Filament\Resources\Pembayaran\Tables\PembayaranTable;
use App\Filament\Traits\HasPropertiAktifScope;
use App\Models\Pembayaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Override;

class PembayaranResource extends Resource
{
    use HasPropertiAktifScope;

    protected static ?string $model = Pembayaran::class;

    protected static ?string $slug = 'pembayaran';

    protected static ?string $pluralLabel = 'Pembayaran';

    protected static ?string $modelLabel = 'Pembayaran';

    protected static ?string $navigationLabel = 'Pembayaran';

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = null;

    public static function form(Schema $schema): Schema
    {
        return PembayaranForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PembayaranInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PembayaranTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    #[Override]
    public static function hasRecordTitle(): bool
    {
        return true;
    }

    public static function getRecordTitle(?Model $record): string|Htmlable|null
    {
        $namaPenghuni = $record?->sewa?->penghuni?->nama_penghuni;

        return $namaPenghuni ? "Data {$namaPenghuni}" : parent::getRecordTitle($record);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPembayaran::route('/'),
            'create' => CreatePembayaran::route('/create'),
            'view' => ViewPembayaran::route('/{record}'),
            'edit' => EditPembayaran::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return static::applyPropertiAktifScope(
            parent::getRecordRouteBindingEloquentQuery()->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]),
            'sewa.kamar.tipeKamar.properti_id'
        );
    }

    public static function getEloquentQuery(): Builder
    {
        return static::applyPropertiAktifScope(
            parent::getEloquentQuery(),
            'sewa.kamar.tipeKamar.properti_id'
        );
    }
}
