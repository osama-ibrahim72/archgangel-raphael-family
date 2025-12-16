<?php

namespace App\Filament\Resources\FatherResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('students');
    }

    protected static function getModelLabel(): ?string
    {
        return __('student');
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('father_id')
                    ->label(__('the father'))
                    ->relationship('father', 'name')
                    ->default(function () {
                        return $this->getOwnerRecord()->id;
                    })
                    ->disabled(),
                Forms\Components\TextInput::make('name')
                    ->label(__('name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(__('phone'))
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label(__('address'))
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dob')
                    ->label(__('dob'))
                    ->displayFormat('d/m/Y'),
                Forms\Components\Select::make('gender')
                    ->label(__('gender'))
                    ->options([
                        'male' =>__( 'male'),
                        'female' => __('female'),
                    ]),
                Forms\Components\TextInput::make('collage')
                    ->label(__('collage'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('job')
                    ->label(__('job'))
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('address'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->label(__('dob'))
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->formatStateUsing(fn ($state) => __($state))
                    ->label(__('gender'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('collage')
                    ->label(__('collage'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('job')
                    ->label(__('job')),
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
