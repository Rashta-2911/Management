<?php

namespace App\Filament\Resources\TipeKamar;

use App\Filament\Resources\TipeKamar\Pages\CreateTipeKamar;
use App\Filament\Resources\TipeKamar\Pages\EditTipeKamar;
use App\Filament\Resources\TipeKamar\Pages\ListTipeKamar;
use App\Filament\Resources\TipeKamar\Pages\ViewTipeKamar;
use App\Filament\Resources\TipeKamar\Schemas\TipeKamarForm;
use App\Filament\Resources\TipeKamar\Schemas\TipeKamarInfolist;
use App\Filament\Resources\TipeKamar\Tables\TipeKamarTable;
use App\Models\TipeKamar;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Override;
use Illuminate\Support\Facades\Auth;

class TipeKamarResource extends Resource
{
    protected static ?string $model = TipeKamar::class;
    protected static ?string $slug = 'tipe_kamar';

    protected static ?string $navigationLabel = 'Tipe Kamar';
    protected static ?string $modelLabel = 'TipeKamar';
    protected static ?string $pluralModelLabel = 'Tipe Kamar';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Properti';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'Tipe Kamar';

    public static function infolist(Schema $schema): Schema
    {
        return TipeKamarInfolist::configure($schema);
    }

    public static function form(Schema $schema): Schema
    {
        return TipeKamarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TipeKamarTable::configure($table);
    }

    
    public static function getGloballySearchableAttributes(): array
    {
    return ['nama_tipe'];
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
            'index' => ListTipeKamar::route('/'),
            'create' => CreateTipeKamar::route('/create'),
            'view' => ViewTipeKamar::route('/{record}'),
            'edit' => EditTipeKamar::route('/{record}/edit'),
        ];
    }
}


