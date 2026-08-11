<?php

namespace App\Filament\Resources\Properti;

use App\Filament\Resources\Properti\Pages\CreateProperti;
use App\Filament\Resources\Properti\Pages\EditProperti;
use App\Filament\Resources\Properti\Pages\ListProperti;
use App\Filament\Resources\Properti\Pages\ViewProperti;
use App\Filament\Resources\Properti\Schemas\PropertiForm;
use App\Filament\Resources\Properti\Schemas\PropertiInfolist;
use App\Filament\Resources\Properti\Tables\PropertiTable;
use App\Models\Properti;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Override;

class PropertiResource extends Resource
{
    protected static ?string $model = Properti::class;

    protected static ?string $slug = 'properti';

    protected static ?string $recordTitleAttribute = 'Properti';

    protected static ?string $pluralLabel = 'Properti';

    protected static ?string $navigationLabel = 'Properti';

    protected static ?string $modelLabel = 'Properti';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Properti';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 1;

    public static function infolist(Schema $schema): Schema
    {
        return PropertiInfolist::configure($schema);
    }

    public static function form(Schema $schema): Schema
    {
        return PropertiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PropertiTable::configure($table);
    }

    #[Override]
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->guard()->user()->hasRole('pemilik')) {
            $query->where('pemilik_id', auth()->guard()->id());
        }

        return $query;
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
            'index' => ListProperti::route('/'),
            'create' => CreateProperti::route('/create'),
            'view' => ViewProperti::route('/{record}'),
            'edit' => EditProperti::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama_properti'];
    }
}
