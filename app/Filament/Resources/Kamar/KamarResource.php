<?php

namespace App\Filament\Resources\Kamar;

use App\Filament\Resources\Kamar\Pages\CreateKamar;
use App\Filament\Resources\Kamar\Pages\EditKamar;
use App\Filament\Resources\Kamar\Pages\ListKamar;
use App\Filament\Resources\Kamar\Pages\ViewKamar;
use App\Filament\Resources\Kamar\Schemas\KamarForm;
use App\Filament\Resources\Kamar\Schemas\KamarInfolist;
use App\Filament\Resources\Kamar\Tables\KamarTable;
use App\Models\Kamar;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Override;
use Illuminate\Contracts\Support\Htmlable;

class KamarResource extends Resource
{
    protected static ?string $model = Kamar::class;

    protected static ?string $slug = 'kamar';

    protected static ?string $navigationLabel = 'Kamar';
    protected static ?string $pluralLabel = 'Kamar';
    protected static ?string $modelLabel = 'Kamar';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 3;

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Properti';

    protected static ?string $recordTitleAttribute = null; //Penamaan judul halaman edit yang diambil dari Attribute model.

    public static function infolist(Schema $schema): Schema
    {
        return KamarInfolist::configure($schema);
    }
    
    public static function form(Schema $schema): Schema
    {
        return KamarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KamarTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function hasRecordTitle(): bool
    {
        return true;
    }

    public static function getRecordTitle(?Model $record): string|Htmlable|null
    {
        $nomorKamar = $record?->nomor_kamar;

        return $nomorKamar ? "Kamar nomor {$nomorKamar}" : parent::getRecordTitle($record);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKamar::route('/'),
            'create' => CreateKamar::route('/create'),
            'view' => ViewKamar::route('/{record}'),
            'edit' => EditKamar::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function getGloballySearchableAttributes(): array
    {
        return ['nomor_kamar'];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}