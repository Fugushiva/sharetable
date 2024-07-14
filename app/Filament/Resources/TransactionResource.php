<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(function () {
                        return User::selectRaw("id, CONCAT(firstname, ' ', lastname) as full_name")
                            ->pluck('full_name', 'id');
                    })
                    ->required()
                    ->disabled(),
                Forms\Components\Select::make('reservation_id')
                    ->relationship('reservation', 'id')
                    ->required()
                    ->disabled(),
                Forms\Components\Select::make('host_id')
                    ->options(function () {
                        // Sélectionnez uniquement les utilisateurs qui sont des hôtes
                        return User::whereHas('host')
                            ->selectRaw("id, CONCAT(firstname, ' ', lastname) as full_name")
                            ->pluck('full_name', 'id');
                    })
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->disabled(),
                Forms\Components\TextInput::make('currency')
                    ->required()
                    ->maxLength(3)
                    ->disabled(),
                Forms\Components\TextInput::make('payment_status')
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('stripe_transaction_id')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Forms\Components\TextInput::make('commission')
                    ->required()
                    ->numeric()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reservation.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('host.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_status'),
                Tables\Columns\TextColumn::make('stripe_transaction_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commission')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
