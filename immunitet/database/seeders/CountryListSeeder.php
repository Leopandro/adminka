<?php
namespace Database\Seeders;

use App\Domain\Country\Model\Country;
use Illuminate\Database\Seeder;

/**
 * Class CountriesSeeder
 * Заполняет таблицу списком стран
 */
class CountryListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \BenSampo\Enum\Exceptions\InvalidEnumMemberException
     */
    public function run()
    {
        foreach ($this->getCountryList() as $countryItem) {
            $country = new Country();
            $country->name = $countryItem;
            $country->save();
        }
    }

    public function getCountryList()
    {
        return [
            'Армения',
            'Белоруссия',
            'Грузия',
            'Россия',
            'Казахстан',
            'Киргизия',
            'Таджикистан',
            'Украина',
            'Узбекистан',
        ];
    }
}
