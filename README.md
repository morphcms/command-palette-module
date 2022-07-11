# Command Palette

## Installation

```shell
php artisan module:install morphcms/command-palette-module
```

via Composer

You have to paste the repository path within your `composer.json` file.

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:morphcms/command-palette-module.git"
        }
    ]
}
```

Then run:

```shell
composer require morphcms/command-palette-module
```

## Usage

From within your module service provider or EventServiceProvider you can register your listeners to the `CommandSearch`
event.

```php 
CommandSearch::class => [
    // Register your listeners here.
],
```

The listener must extend the `CollectionSearchListener` or the `CommandSearchListener`.

Perform a command search to the `api` route `/commands/search`.

Request Parameters:

```php
'query' => ['required', 'string'],
'limit' => ['sometimes', 'numeric', 'min:1', 'max:100'],
'args' => ['array', 'nullable'],
'args.*' => [],
'options' => ['array', 'nullable'],
'options.*' => [],
```

Returns an array of `SearchResult`.

```json
{
    "group": [
        {
            "type": "resource-type",
            "meta": []
        }
    ],
    "blog": [
        {
            "type": "posts",
            "title": "My first post",
            "icon": "DocumentText",
            "description": "Some post summary.",
            "group": "blog",
            "meta": []
        }
    ]
}
```

## Creating a CollectionSearchListener

The `CollectionSearchListener` is used when you want to hardcode a list of `SearchResult` that will be searched using
the 'contains' method.

```php
use Modules\CommandPalette\ActionTypes\NavigateAction;
use Modules\CommandPalette\ActionTypes\ToastAction;
use Modules\CommandPalette\DTO\SearchResult;
use Modules\CommandPalette\Enums\CommandIcon;
use Modules\CommandPalette\Listeners\CollectionSearchListener;

class GeneralCommandsSearchListener extends CollectionSearchListener
{
    public function items(): array
    {
        return [
            SearchResult::make('Greet') // The command title that will also be searched
                ->group('Admin') // Just a name to nicely group results
                ->icon(CommandIcon::LightningBolt) // Uses Hero Icons package
                ->description('Says hello back to you.') // A summary of what this command or this result does.
                ->action(ToastAction::make()->message('Hello, '.auth()->user()->name.'!')), // Action is catched on the frontend, this should send a payload
        ];
    }
}
 ```

## Creating a CommandSearchListener

The `CommandSearchListener` is the base listener where you have to implement the way you search and fetch the results.
It must return a **collection** of `SearchResult`

```php
namespace App\Listeners;

use Illuminate\Support\Collection;
use Modules\Blog\Models\Post;
use Modules\CommandPalette\ActionTypes\NavigateAction;
use Modules\CommandPalette\DTO\SearchResult;
use Modules\CommandPalette\Enums\CommandIcon;
use Modules\CommandPalette\Events\CommandSearch;
use Modules\CommandPalette\Listeners\CommandSearchListener;

class GeneralCommandsSearchListener extends CommandSearchListener
{
    protected function search(CommandSearch $event): Collection|null
    {
        return Model::search($event->query)
            ->limit($event->limit)
            ->get()
            ->map(fn (Model $model) => 
                SearchResult::make(
                    title: $model->title,
                    type: 'resource_name',
                )->group('Resource Name')
                 ->icon(CommandIcon::Sparkles)
                 ->action(NavigateAction::make(['id' => $model->id]))
            );
    }
}
```

## Examples of Search Listeners

### Blog posts example

```php
namespace App\Listeners\Commands;

use Illuminate\Support\Collection;
use Modules\Blog\Models\Post;
use Modules\Shop\Enums\ProductStatus;

use Modules\CommandPalette\ActionTypes\NavigateAction;
use Modules\CommandPalette\DTO\SearchResult;
use Modules\CommandPalette\Enums\CommandIcon;
use Modules\CommandPalette\Events\CommandSearch;
use Modules\CommandPalette\Listeners\CommandSearchListener;

class BlogCommandsSearchListener extends CommandSearchListener
{
    // This implementation uses Scout for search
    protected function search(CommandSearch $event): Collection|null
    {
        return Post::search($event->query)
            ->query(fn ($q) => $q->where('status', ProductStatus::Published->value))
            ->get()
            ->map(fn (Post $post) => SearchResult::make(
                title: $post->title,
                type: 'post',
            )->group('Blog')
                ->icon(CommandIcon::DocumentText)
                ->action(NavigateAction::make(['slug' => $post->slug]))
            );
    }
}
```

### Custom commands example with authorization

```php
namespace App\Listeners\Commands;

use Laravel\Nova\Nova;use Modules\CommandPalette\ActionTypes\NavigateAction;
use Modules\CommandPalette\ActionTypes\ToastAction;
use Modules\CommandPalette\DTO\SearchResult;
use Modules\CommandPalette\Enums\CommandIcon;
use Modules\CommandPalette\Listeners\CollectionSearchListener;

class AdminCommandsSearchListener extends CollectionSearchListener
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function items(): array
    {
        return [
            SearchResult::make('Create Product')
                ->group('Admin')
                ->icon(CommandIcon::LightningBolt)
                ->action(
                    NavigateAction::make([
                        'url' => Nova::url('/resources/products/new'),
                ])),
        ];
    }
}
```

## Command Actions

The `CommandAction` type is nothing more than a data transfer object with a fluent API.

The only two required attributes are `type` and `meta`.

### Creating a `CustomAction`

```php
namespace Modules\CommandPalette\ActionTypes;

use Modules\CommandPalette\DTO\CommandAction;

class MyCommandAction extends CommandAction
{
    public function __construct(array $meta = [])
    {
        parent::__construct('my-type', $meta);
    }
} 
```


