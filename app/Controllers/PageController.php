<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Data\Services;
use App\Models\Post;

final class PageController
{
    public function home(): string
    {
        return view('pages/home', [
            'title'    => 'Freight Forwarder in Karachi | Sea, Air & Customs Clearance',
            'metaDesc' => 'ALPHA Global Shipping & Logistics: reliable ocean freight, air cargo, customs clearance and warehousing from Karachi, Pakistan to the world.',
            'services' => Services::all(),
            'posts'    => $this->safePosts(),
        ]);
    }

    public function about(): string
    {
        return view('pages/about', [
            'title'    => 'About Us',
            'metaDesc' => 'Learn about ALPHA Global Shipping & Logistics, our mission, values and the team behind your cargo in Karachi, Pakistan.',
        ]);
    }

    public function services(): string
    {
        return view('pages/services', [
            'title'    => 'Our Services',
            'metaDesc' => 'Ocean freight, air cargo, customs clearance, warehousing, land transport and project logistics from Karachi, Pakistan.',
            'services' => Services::all(),
        ]);
    }

    public function service(string $slug): string
    {
        $service = Services::find($slug);
        if (!$service) {
            abort(404);
        }
        return view('pages/service-detail', [
            'title'    => $service['title'],
            'metaDesc' => $service['summary'],
            'service'  => $service,
            'slug'     => $slug,
            'others'   => array_diff_key(Services::all(), [$slug => true]),
        ]);
    }

    public function contact(): string
    {
        return view('pages/contact', [
            'title'    => 'Contact Us',
            'metaDesc' => 'Contact ALPHA Global Shipping & Logistics in Karachi. Call 021-32316744-5 or send us your query online.',
        ]);
    }

    public function quote(): string
    {
        $service = (string) input('service', '');
        return view('pages/quote', [
            'title'    => 'Request a Freight Quote',
            'metaDesc' => 'Request a free freight quote for sea, air, land or customs services from Karachi, Pakistan.',
            'preset'   => in_array($service, Services::formOptions(), true) ? $service : '',
        ]);
    }

    public function privacy(): string
    {
        return view('pages/privacy', ['title' => 'Privacy Policy', 'metaDesc' => 'How ALPHA Global Shipping & Logistics collects and uses your information.']);
    }

    public function terms(): string
    {
        return view('pages/terms', ['title' => 'Terms & Conditions', 'metaDesc' => 'Terms and conditions for using the ALPHA Global Shipping & Logistics website.']);
    }

    private function safePosts(): array
    {
        try {
            return Post::latest(3);
        } catch (\Throwable) {
            return [];
        }
    }
}
