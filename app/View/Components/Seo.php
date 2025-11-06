<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Seo extends Component
{
    public string $title;
    public string $description;
    public ?string $image;
    public string $url;
    public string $type;
    public ?array $schema;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $title = null,
        ?string $description = null,
        ?string $image = null,
        ?string $url = null,
        string $type = 'website',
        ?array $schema = null
    ) {
        $appName = config('app.name', 'Webshop');

        $this->title = $title
            ? $title . ' - ' . $appName
            : $appName;

        $this->description = $description ?? 'Welcome to our amazing webshop. Find the best products at great prices.';

        $this->image = $image
            ? (filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image))
            : asset('images/og-default.jpg');

        $this->url = $url ?? request()->url();
        $this->type = $type;
        $this->schema = $schema;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.seo');
    }
}
