<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
// use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                    Forms\Components\Select::make('shift_id')
                            ->label('shift')
                            ->relationship('shift', 'start_at')
                            ->preload()
                            ->searchable()
                            ->required(),
                    Forms\Components\Select::make('created_by')
                            ->label('created_by')
                            ->relationship('created_by', 'start_at')
                            ->preload()
                            ->searchable()
                            ->required(),
                    // Forms\Components\TextInput::make('customer_id')
                    //     ->required(),
                    // Forms\Components\TextInput::make('shift_id')
                    //     ->required(),
                    // Forms\Components\TextInput::make('created_by')
                    //     ->required(),
                    Forms\Components\TextInput::make('total_amount'),
                    Forms\Components\Toggle::make('paid')
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name'),
                Tables\Columns\TextColumn::make('shift.start_at'),
                Tables\Columns\TextColumn::make('createdby.name'),
                Tables\Columns\TextColumn::make('total_amount'),
                Tables\Columns\IconColumn::make('paid')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
            RelationManagers\ShiftsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
