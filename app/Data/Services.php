<?php
declare(strict_types=1);

namespace App\Data;

/** Static service catalogue. Edit here to change the Services pages. */
final class Services
{
    public static function all(): array
    {
        return [
            'ocean-freight' => [
                'title' => 'Ocean Freight (FCL / LCL)',
                'short' => 'Ocean Freight',
                'icon'  => 'fa-ship',
                'form'  => 'Ocean FCL',
                'summary' => 'Full-container and consolidated sea freight from Karachi to every major port worldwide.',
                'intro' => 'We book FCL and LCL shipments on trusted shipping lines, handle documentation and keep you updated from loading to discharge. Whether you ship one pallet or fifty containers, our team finds the right sailing at a competitive rate.',
                'features' => [
                    'FCL: 20ft, 40ft and 40ft High Cube containers',
                    'LCL consolidation with regular weekly sailings',
                    'Reefer, open-top and flat-rack equipment on request',
                    'Bill of Lading, Packing List and Certificate of Origin support',
                    'Cargo insurance arranged on request',
                    'Door-to-door and port-to-port options',
                ],
                'steps' => [
                    ['Request a Quote', 'Tell us your cargo, origin and destination.'],
                    ['Booking', 'We confirm space and sailing schedule.'],
                    ['Documentation', 'We prepare and verify shipping documents.'],
                    ['Shipping & Tracking', 'Your cargo sails and we track it for you.'],
                    ['Delivery', 'Cargo is released and delivered at destination.'],
                ],
                'faq' => [
                    ['What is the difference between FCL and LCL?', 'FCL (Full Container Load) means you use the whole container. LCL (Less than Container Load) means your cargo shares a container with others, so you pay only for the space you use.'],
                    ['How long does ocean freight take?', 'Transit time depends on the route. Typical transit from Karachi is 8–14 days to the Gulf, 20–30 days to Europe and 30–40 days to North America.'],
                    ['Can you arrange delivery to my warehouse?', 'Yes. We offer door-to-door service including trucking at origin and destination.'],
                ],
            ],
            'air-freight' => [
                'title' => 'Air Cargo Express & Charter',
                'short' => 'Air Freight',
                'icon'  => 'fa-plane',
                'form'  => 'Air Freight',
                'summary' => 'Time-critical air freight with fast departures and tight handling.',
                'intro' => 'When time matters, air freight gets your goods there in days. We work with leading airlines and consolidators to give you reliable capacity, competitive rates and careful handling for urgent, high-value or perishable cargo.',
                'features' => [
                    'Express, standard and deferred air freight services',
                    'Airport-to-airport and door-to-door delivery',
                    'Perishable, pharmaceutical and dangerous-goods handling',
                    'Full and part charter for oversized shipments',
                    'Airway Bill preparation and export clearance support',
                    'Real-time status updates',
                ],
                'steps' => [
                    ['Quote', 'Share weight, dimensions and destination.'],
                    ['Booking', 'We reserve space on the next available flight.'],
                    ['Pick-up & Export Clearance', 'We collect and clear your cargo.'],
                    ['Flight', 'Your cargo departs and we monitor it.'],
                    ['Delivery', 'We hand over at destination.'],
                ],
                'faq' => [
                    ['How is air freight priced?', 'Air freight is charged by chargeable weight, which is the greater of actual weight and volumetric weight (length × width × height in cm ÷ 6000).'],
                    ['Can you ship urgent same-week cargo?', 'In most cases yes, subject to flight availability. Contact us with your cargo details for an immediate quote.'],
                ],
            ],
            'customs-clearance' => [
                'title' => 'Customs Brokerage & Clearance',
                'short' => 'Customs Clearance',
                'icon'  => 'fa-file-signature',
                'form'  => 'Customs Clearance',
                'summary' => 'Fast, compliant import and export clearance at Karachi ports and airports.',
                'intro' => 'Our clearing team handles import and export declarations, duty assessment and port formalities so your cargo moves without delays. We keep you informed at each step and make sure the paperwork is right the first time.',
                'features' => [
                    'Import and export customs declarations',
                    'HS code classification and duty calculation',
                    'Port, terminal and airport coordination',
                    'Examination, valuation and release follow-up',
                    'Advice on import regulations and required licences',
                    'Transparent, itemised charges',
                ],
                'steps' => [
                    ['Share Documents', 'Send invoice, packing list and shipping documents.'],
                    ['Filing', 'We file the declaration and assess duties.'],
                    ['Examination', 'We attend inspection where required.'],
                    ['Release', 'We pay duties on your behalf and secure release.'],
                    ['Delivery', 'Cargo is released for delivery.'],
                ],
                'faq' => [
                    ['Which documents do I need for import clearance?', 'Typically a commercial invoice, packing list, Bill of Lading or Airway Bill, and any required licences or certificates. We will confirm exactly what your cargo needs.'],
                    ['Do you handle exports too?', 'Yes. We prepare export declarations and coordinate with the port or airport for shipment.'],
                ],
            ],
            'warehousing' => [
                'title' => 'Bonded Warehousing & Distribution',
                'short' => 'Warehousing',
                'icon'  => 'fa-warehouse',
                'form'  => 'Warehousing',
                'summary' => 'Secure storage, inventory control and distribution across Pakistan.',
                'intro' => 'We provide safe short-term and long-term storage, with inventory management and delivery to your customers. Our warehousing keeps your stock protected and ready to move when you need it.',
                'features' => [
                    'Secure, monitored storage facilities',
                    'Inventory tracking and stock reports',
                    'Pick, pack and dispatch services',
                    'Palletising, labelling and re-packing',
                    'Bonded storage for duty-deferred cargo',
                    'Distribution to cities across Pakistan',
                ],
                'steps' => [
                    ['Assessment', 'We review your storage and volume needs.'],
                    ['Receiving', 'Cargo is checked in and recorded.'],
                    ['Storage', 'Your goods are stored securely.'],
                    ['Order Processing', 'We pick, pack and prepare orders.'],
                    ['Dispatch', 'Orders are delivered on schedule.'],
                ],
                'faq' => [
                    ['Can I store goods for a short period?', 'Yes. We offer flexible short-term and long-term arrangements.'],
                    ['Do you provide stock reports?', 'Yes. We can supply regular inventory reports on request.'],
                ],
            ],
            'transportation' => [
                'title' => 'Transportation (Road & Rail)',
                'short' => 'Transportation',
                'icon'  => 'fa-truck-fast',
                'form'  => 'Transportation',
                'summary' => 'Truckload, LTL, refrigerated and rail transport across Pakistan and Afghanistan.',
                'intro' => 'Whether you need to move a single load, handle a spike in volume or make your whole transportation spend more predictable, we know what it takes to get your business moving. We cover more of your freight through one source with a full range of transport solutions, including Truckload, Intermodal, Refrigerated and Less-than-Truckload (LTL) services, and we can take over your transportation completely, including the loads that are hardest to move.',
                // Extra headed paragraphs, shown after the intro.
                'sections' => [
                    ['Effective logistics solutions are the basis of our success', 'We offer a broad range of land transport options: trailers for dry containers, temperature-controlled moves, open-bed trucks for loose and out-of-gauge cargo, low-bed trucks, and trucks of every size for efficient road deliveries. We also offer rail for loose and containerised cargo. Our transport solutions optimise your cargo flow across Pakistan and Afghanistan, and our industry-specific dedicated transport gives you more control over how your product moves.'],
                    ['Our main objective', 'Your products should always arrive on time and in good order, so you can concentrate on your business.'],
                ],
                // "Special services" cards: [title, text].
                'highlights' => [
                    ['Price Advantage', 'We watch every cost and aim to deliver your solution for less than other logistics providers. We take care of our customers\' money.'],
                    ['Our Effectiveness', 'One logistics setup that provides a full range of value-added services, backed by quality customer service.'],
                    ['Our Solutions', 'We have built our logistics skills to international standards and handle every kind of logistics requirement.'],
                ],
                'capabilities' => [
                    'Time-definite and efficient',
                    'Cost-effective solutions',
                    'Insured transportation moves',
                    'Product-specific solutions',
                    'Door-to-door deliveries',
                    'Flexible costs',
                    'Loading and unloading capabilities',
                    'Loading equipment',
                    'Best-value transporters\' panel',
                ],
                'features' => [
                    'Road trucking',
                    'Rail service',
                    'Conventionally loaded dry containers',
                    'Empty container repositioning',
                    'Inland destinations in Pakistan and Afghanistan',
                    'Low-bed vehicles',
                    'Special equipment trucking',
                    'Out-of-gauge cargo service',
                    'Small trucks for swift deliveries',
                    'Supply chain deliveries',
                ],
                'steps' => [
                    ['Request', 'Send pick-up and delivery details.'],
                    ['Dispatch', 'We assign a suitable vehicle.'],
                    ['Transit', 'Cargo is moved and monitored.'],
                    ['Delivery', 'We deliver and provide proof of delivery.'],
                ],
                'faq' => [
                    ['Which cities do you deliver to?', 'We deliver across Pakistan, including Karachi, Lahore, Faisalabad, Islamabad, Peshawar and more.'],
                ],
            ],
            'project-cargo' => [
                'title' => 'Heavy Lift & Project Logistics',
                'short' => 'Project Cargo',
                'icon'  => 'fa-weight-hanging',
                'form'  => 'Project Cargo',
                'summary' => 'Planning and moving oversized, heavy and out-of-gauge cargo.',
                'intro' => 'Industrial equipment, machinery and project cargo need careful planning. We survey, plan routes, arrange specialist equipment and manage every step from origin to site.',
                'features' => [
                    'Route surveys and transport engineering',
                    'Break-bulk, out-of-gauge and heavy-lift cargo',
                    'Specialist trailers, cranes and lifting equipment',
                    'Lashing, securing and marine surveys',
                    'Permits and port coordination',
                    'Single point of contact for the whole project',
                ],
                'steps' => [
                    ['Consultation', 'We study your cargo and project requirements.'],
                    ['Planning', 'We design the route, equipment and schedule.'],
                    ['Execution', 'We move and secure the cargo.'],
                    ['Handover', 'We deliver on site and close out documents.'],
                ],
                'faq' => [
                    ['Can you handle out-of-gauge cargo?', 'Yes. We handle break-bulk and out-of-gauge cargo, with route and equipment planning.'],
                ],
            ],
        ];
    }

    public static function find(string $slug): ?array
    {
        return self::all()[$slug] ?? null;
    }

    /** Options for quote forms. */
    public static function formOptions(): array
    {
        return array_values(array_map(fn($s) => $s['form'], self::all()));
    }
}
