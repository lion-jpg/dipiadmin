<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaludResource\Pages;
use App\Filament\Resources\SaludResource\RelationManagers;
use App\Models\Salud;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaludResource extends Resource
{
    protected static ?string $model = Salud::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Salud';
    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationBadgeTooltip = 'The number of salud';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }   
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo_sal')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descripcion_sal')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('imagen_sal')
                    ->preserveFilenames(),
                Forms\Components\FileUpload::make('video_sal')
                    ->preserveFilenames()
                    ->disk('public')
                    ->directory('videos')
                    ->maxSize(100000) // 100 MB (el valor está en KB)
                    // ->acceptedFileTypes(['video/mp4', 'video/mov', 'video/avi'])
                    ->columnSpanFull()
                    ->helperText('Formatos aceptados: MP4, MOV, AVI. Tamaño máximo: 100MB')
                    ->hint('Asegúrate de que el archivo no exceda el límite de tamaño')
                    ->hintIcon('heroicon-m-information-circle'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo_sal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion_sal')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('imagen_sal')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('video_sal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSaluds::route('/'),
            'create' => Pages\CreateSalud::route('/create'),
            'edit' => Pages\EditSalud::route('/{record}/edit'),
        ];
    }
}
