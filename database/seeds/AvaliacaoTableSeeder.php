<?php

use App\Models\Avaliacao;
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use Illuminate\Support\Facades\DB;

class AvaliacaoTableSeeder extends Seeder
{
    private $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = FactoryFaker::create('pt_BR');

        try {
            DB::beginTransaction();
            $this->questoes($this->avaliacao());
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
        }
    }

    private function avaliacao()
    {
        return Avaliacao::create(['titulo' => 'Avaliação ' . $this->faker->company]);
    }

    private function questoes(Avaliacao $avaliacao)
    {
        for ($i = 0; $i < 10; $i++) {
            $this->storeQuestao($avaliacao, 'multipla');
        }

        $this->storeQuestao($avaliacao, 'dissertativa');
        $this->storeQuestao($avaliacao, 'dissertativa');
    }

    private function storeQuestao(Avaliacao $avaliacao, $tipo)
    {
        $avaliacao->questoes()->create([
            'titulo' => $this->faker->jobTitle,
            'pergunta' => $this->faker->sentence . '?',
            'tipo' => $tipo
        ]);
    }
}
