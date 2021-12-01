<?php

namespace Marshmallow\Reviews\Kiyoh\Nova;

use App\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\BelongsTo;
use Marshmallow\Reviews\Kiyoh\Kiyoh;

/**
 * This class handles the behaviour of the
 * nova resource for this model.
 *
 * @category Product
 * @package  Product
 * @author   Stef van Esch <stef@marshmallow.dev>
 * @license  MIT Licence
 * @link     https://marshmallow.dev
 */
class KiyohProduct extends Resource
{
    public static $model = 'Marshmallow\Reviews\Kiyoh\Models\KiyohProduct';

    public static $title = 'product_name';

    public static $search = [
        'kiyoh_id',
        'product_id',
        'cluster_id',
        'product_code',
        'cluster_code',
        'product_name',
        'image_url',
        'source_url',
    ];

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Fields for this resource. Extended by the fields
     * that are default by the package
     *
     * @param Request $request Request object
     *
     * @return array Array of fields
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Kiyoh ID'), 'kiyoh_id')->sortable(),

            Heading::make(__('Product')),
            BelongsTo::make(__('Product'), 'product', Kiyoh::$productResource)->sortable(),
            Text::make(__('URL'), 'source_url')->resolveUsing(function ($value) {
                return '<a href="' . $value . '" target="_blank">' . __('View') . '</a>';
            })->asHtml(),
            Text::make(__('Product code'), 'product_code')->sortable()->hideFromIndex(),
            Text::make(__('Product name'), 'product_name')->sortable()->hideFromIndex(),
            Avatar::make(__('Image'), 'image_url')->thumbnail(function ($value) {
                return $value;
            })->preview(function ($value) {
                return $value;
            }),
            Heading::make(__('Cluster')),
            Text::make(__('Cluster ID'), 'cluster_id')->sortable()->hideFromIndex(),
            Text::make(__('Cluster code'), 'cluster_code')->sortable()->hideFromIndex(),
            Heading::make(__('Settings')),
            Boolean::make(__('Active'), 'active'),
        ];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    /**
     * Cards for this resource. Extended by the cards
     * that are default by the package
     *
     * @param Request $request Request object
     *
     * @return array Array of cards
     */
    public function cards(Request $request)
    {
        return [];
    }


    /**
     * Filters for this resource. Extended by the filters
     * that are default by the package
     *
     * @param Request $request Request object
     *
     * @return array Array of filters
     */
    public function filters(Request $request)
    {
        return [];
    }


    /**
     * Lenses for this resource. Extended by the lenses
     * that are default by the package
     *
     * @param Request $request Request object
     *
     * @return array Array of lenses
     */
    public function lenses(Request $request)
    {
        return [];
    }


    /**
     * Actions for this resource. Extended by the actions
     * that are default by the package
     *
     * @param Request $request Request object
     *
     * @return array Array of actions
     */
    public function actions(Request $request)
    {
        return [];
    }
}
