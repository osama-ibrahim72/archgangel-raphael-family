<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('attendances');
    }

    protected static function getModelLabel(): ?string
    {
        return __('attendance');
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('meeting_id')
                    ->label(__('meeting'))
                    ->relationship('meeting', 'title')
                    ->default(function () {
                        return $this->getOwnerRecord()->id;
                    })
                    ->disabled(),
                Forms\Components\Select::make('user_id')
                    ->label(__('student'))
                    ->relationship('student' , 'name'),
                Forms\Components\Toggle::make('attend')
                    ->label(__('attend'))
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('attend')
            ->columns([
                TextColumn::make('student.name')
                    ->label(__('student')),
                Tables\Columns\ToggleColumn::make('attend')
                    ->label(__('attend')),
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
