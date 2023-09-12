<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($params as $item)
        @if($item['loc'])
            <url>
                <loc>{{ $item['loc'] }}</loc>

                @if(isset($item['lastmod']))
                    <lastmod>{{ $item['lastmod'] }}</lastmod>
                @endif

                @if(isset($item['changefreq']))
                    <changefreq>{{ $item['changefreq'] }}</changefreq>
                @endif

                @if(isset($item['priority']))
                    <priority>{{ $item['priority'] }}</priority>
                @endif
            </url>
        @endif
    @endforeach
</urlset>
