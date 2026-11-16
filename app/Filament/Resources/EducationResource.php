<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationResource\Pages;
use App\Filament\Resources\EducationResource\RelationManagers;
use App\Models\Education;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('profile_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('institution')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('degree')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('period')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('start_year')
                    ->numeric()
                    ->default(null),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('tags')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('profile_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('institution')
                    ->searchable(),
                Tables\Columns\TextColumn::make('degree')
                    ->searchable(),
                Tables\Columns\TextColumn::make('period')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_year')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListEducation::route('/'),
            'create' => Pages\CreateEducation::route('/create'),
            'edit' => Pages\EditEducation::route('/{record}/edit'),
        ];
    }
}
