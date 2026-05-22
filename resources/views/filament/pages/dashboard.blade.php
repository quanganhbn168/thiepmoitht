<x-filament-panels::page class="fi-dashboard-page">
    @if (auth()->user()?->isCustomer())
        <div class="grid gap-4 md:grid-cols-2">
            @foreach ($this->getCustomerQuickLinks() as $link)
                <a
                    href="{{ $link['url'] }}"
                    class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900"
                >
                    <div class="text-lg font-semibold text-gray-950 dark:text-white">
                        {{ $link['title'] }}
                    </div>

                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                        {{ $link['description'] }}
                    </p>
                </a>
            @endforeach
        </div>
    @else
        @if (method_exists($this, 'filtersForm'))
            {{ $this->filtersForm }}
        @endif

        <x-filament-widgets::widgets
            :columns="$this->getColumns()"
            :data="
                [
                    ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                    ...$this->getWidgetData(),
                ]
            "
            :widgets="$this->getVisibleWidgets()"
        />
    @endif
</x-filament-panels::page>
