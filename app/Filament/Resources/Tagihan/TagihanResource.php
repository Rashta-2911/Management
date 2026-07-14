<?php

namespace App\Filament\Resources\Tagihan;

use App\Filament\Resources\Tagihan\Pages\CreateTagihan;
use App\Filament\Resources\Tagihan\Pages\EditTagihan;
use App\Filament\Resources\Tagihan\Pages\ListTagihan;
use App\Filament\Resources\Tagihan\Pages\ViewTagihan;
use App\Filament\Resources\Tagihan\Schemas\TagihanForm;
use App\Filament\Resources\Tagihan\Schemas\TagihanInfolist;
use App\Filament\Resources\Tagihan\Tables\TagihanTable;
use App\Models\Tagihan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Table;
use Override;

class TagihanResource extends Resource
{
    protected static ?string $model = Tagihan::class;
    protected static ?string $slug = 'tagihan';
    protected static ?string $navigationLabel = 'Tagihan';
    protected static ?string $pluralLabel = 'Tagihan';
    

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'tagihan_id';

    public static function form(Schema $schema): Schema
    {
        return TagihanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TagihanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TagihanTable::configure($table);
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
            'index' => ListTagihan::route('/'),
            'create' => CreateTagihan::route('/create'),
            'view' => ViewTagihan::route('/{record}'),
            'edit' => EditTagihan::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function getGloballySearchableAttributes(): array
    {
        return ['id'];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
