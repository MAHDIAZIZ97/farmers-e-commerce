<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('id')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                   ->label('Order ID')
                   ->searchable(true),
                TextColumn::make('grand_total')
                   ->money('INR'),
                TextColumn::make('status')
                   ->badge()
                   ->color(fn (string $state) => match($state){
                       'new' => 'info',
                       'processing' => 'warning',
                       'shipped' => 'success',
                       'delivered' => 'primary',
                       'cancelled' => 'danger',
                   })
                   ->icon(
                    fn (string $state) => match($state){
                        'new' => 'heroicon-m-sparkles',
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-track',
                        'delivered' => 'heroicon-m-check-badge',
                        'cancelled' => 'heroicon-m-x-circle',
                    }
                   )
                   ->sortable(),
                TextColumn::make('payment_method')
                    ->sortable()
                    ->searchable(true),
                TextColumn::make('payment_status')
                    ->sortable(true)
                    ->badge()
                    ->searchable(true),
                TextColumn::make('created_at')
                   ->label('Order Date')
                   ->datetime(),
                // Add more columns as needed...
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('View')
                   ->url(fn (Order $record) => OrderResource::getUrl('view',['record'=>$record]))
                   ->color('info')
                   ->icon('heroicon-m-eye'),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
