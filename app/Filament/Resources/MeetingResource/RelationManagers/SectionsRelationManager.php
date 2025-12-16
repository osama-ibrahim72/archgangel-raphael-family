<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';


    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('sections');
    }

    protected static function getModelLabel(): ?string
    {
        return __('section');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('teacher_id')
                    ->label(__('teacher'))
                    ->relationship('teacher', 'name'),
                Forms\Components\Select::make('father_id')
                    ->label(__('father'))
                 ->relationship('father', 'name'),
                Forms\Components\TextInput::make('notes')
                    ->label(__('notes')),
                Forms\Components\TextInput::make('sort')
                    ->label(__('sort'))
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('title')),
                Tables\Columns\TextColumn::make('sort')
                    ->label(__('sort'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label(__('teacher')),
                Tables\Columns\TextColumn::make('father.name')
                    ->label(__('father')),
                Tables\Columns\TextColumn::make('notes')
                    ->label(__('notes')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
