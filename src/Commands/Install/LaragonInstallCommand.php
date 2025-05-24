<?php

namespace App\Commands\Setup;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class LaragonInstallCommand extends Command
{
    protected function configure()
    {
        $this->setName('laragon:install');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = new Client([
            'base_uri' => 'https://api.github.com/',
            'headers' => [
                'User-Agent' => 'devx-cli',
            ],
        ]);

        try {
            $response = $client->get('repos/leokhoa/laragon/releases/latest');
            $data = json_decode($response->getBody()->getContents(), true);

            $version = $data['tag_name'] ?? 'unknown';
            $assets = $data['assets'] ?? [];

            if (empty($assets)) {
                $output->writeln("<error>Aucun fichier à télécharger trouvé pour la version {$version}.</error>");
                return Command::FAILURE;
            }

            $output->writeln("✔️ Dernière version de Laragon : <info>{$version}</info>");
            $choices = [];
            foreach ($assets as $index => $asset) {
                $choices[] = "{$asset['name']} ({$asset['size']} octets)";
            }

            /** @var QuestionHelper $helper */
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Quel fichier souhaitez-vous télécharger ?',
                $choices
            );
            $selected = $helper->ask($input, $output, $question);
            $selectedIndex = array_search($selected, $choices);

            $selectedAsset = $assets[$selectedIndex];
            $downloadUrl = $selectedAsset['browser_download_url'];
            $filename = $selectedAsset['name'];

            $output->writeln("📥 Téléchargement de <info>{$filename}</info> depuis <comment>{$downloadUrl}</comment>");

            $savePath = getcwd() . DIRECTORY_SEPARATOR . $filename;
//            die($savePath);
            file_put_contents($savePath, fopen($downloadUrl, 'r'));

            $output->writeln("✅ Fichier téléchargé ici : <info>{$savePath}</info>");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln("<error>Erreur : {$e->getMessage()}</error>");
            return Command::FAILURE;
        }
    }
}
