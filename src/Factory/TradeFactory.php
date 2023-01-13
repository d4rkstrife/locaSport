<?php

namespace App\Factory;

use App\Entity\Trade;
use App\Repository\TradeRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Trade>
 *
 * @method        Trade|Proxy create(array|callable $attributes = [])
 * @method static Trade|Proxy createOne(array $attributes = [])
 * @method static Trade|Proxy find(object|array|mixed $criteria)
 * @method static Trade|Proxy findOrCreate(array $attributes)
 * @method static Trade|Proxy first(string $sortedField = 'id')
 * @method static Trade|Proxy last(string $sortedField = 'id')
 * @method static Trade|Proxy random(array $attributes = [])
 * @method static Trade|Proxy randomOrCreate(array $attributes = [])
 * @method static TradeRepository|RepositoryProxy repository()
 * @method static Trade[]|Proxy[] all()
 * @method static Trade[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Trade[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Trade[]|Proxy[] findBy(array $attributes)
 * @method static Trade[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Trade[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class TradeFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'date' => self::faker()->dateTime(),
            'tenant' => UserFactory::random(),
            'material'=>MaterialFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Trade $trade): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Trade::class;
    }
}
