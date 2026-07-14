<?php

namespace App\Filament\Resources\Sewa;

use App\Filament\Resources\Sewa\Pages\CreateSewa;
use App\Filament\Resources\Sewa\Pages\EditSewa;
use App\Filament\Resources\Sewa\Pages\ListSewa;
use App\Filament\Resources\Sewa\Pages\ViewSewa;
use App\Filament\Resources\Sewa\Schemas\SewaForm;
use App\Filament\Resources\Sewa\Schemas\SewaInfolist;
use App\Filament\Resources\Sewa\Tables\SewaTable;
use App\Models\Sewa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Override;
use Illuminate\Support\Facades\Auth;

class SewaResource extends Resource
{
    protected static ?string $model = Sewa::class;
    protected static ?string $slug = 'sewa';
    protected static ?string $navigationLabel = 'Sewa';
    protected static ?string $pluralLabel = 'Sewa';
    protected static ?string $modelLabel = 'Sewa';

    protected static string|\UnitEnum|null $navigationGroup = 'Kelola Penghuni';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'sewa_id';

    public static function form(Schema $schema): Schema
    {
        return SewaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SewaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SewaTable::configure($table);
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
            'index' => ListSewa::route('/'),
            'create' => CreateSewa::route('/create'),
            'view' => ViewSewa::route('/{record}'),
            'edit' => EditSewa::route('/{record}/edit'),
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
