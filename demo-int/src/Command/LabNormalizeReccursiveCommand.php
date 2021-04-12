<?php

namespace App\Command;



use App\Model\DeepModel;
use App\Model\Person;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;


class LabNormalizeReccursiveCommand extends Command
{
    protected static $defaultName = 'lab:normalize:reccursive';
    protected static $defaultDescription = 'Add a short description for your command';
    private SerializerInterface $serializer;
    private ObjectNormalizer $objectNormalizer;

    public function __construct(SerializerInterface $serializer, ObjectNormalizer $objectNormalizer, string $name = null)
    {
        parent::__construct($name);
        $this->serializer = $serializer;
        $this->objectNormalizer = $objectNormalizer;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $flux = $this->getDeepSteam();

//        $test = $this->serializer->deserialize($flux, DeepModel::class, 'json');
        $array = json_decode($flux, true);
        $test2 = $this->objectNormalizer->denormalize($array, DeepModel::class);
        dd($test2, $array);
        return Command::SUCCESS;
    }

    public function getDeepSteam()
    {
        return '{"page":2,"per_page":6,"total":12,"total_pages":2,"data":[{"id":7,"email":"michael.lawson@reqres.in","first_name":"Michael","last_name":"Lawson","avatar":"https://reqres.in/img/faces/7-image.jpg"},{"id":8,"email":"lindsay.ferguson@reqres.in","first_name":"Lindsay","last_name":"Ferguson","avatar":"https://reqres.in/img/faces/8-image.jpg"},{"id":9,"email":"tobias.funke@reqres.in","first_name":"Tobias","last_name":"Funke","avatar":"https://reqres.in/img/faces/9-image.jpg"},{"id":10,"email":"byron.fields@reqres.in","first_name":"Byron","last_name":"Fields","avatar":"https://reqres.in/img/faces/10-image.jpg"},{"id":11,"email":"george.edwards@reqres.in","first_name":"George","last_name":"Edwards","avatar":"https://reqres.in/img/faces/11-image.jpg"},{"id":12,"email":"rachel.howell@reqres.in","first_name":"Rachel","last_name":"Howell","avatar":"https://reqres.in/img/faces/12-image.jpg"}],"support":{"url":"https://reqres.in/#support-heading","text":"To keep ReqRes free, contributions towards server costs are appreciated!"}}';
    }
}
