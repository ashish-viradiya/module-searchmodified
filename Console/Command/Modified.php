<?php
/**
 * Created by PhpStorm.
 * User: ashish
 * Date: 13/11/2018
 * Time: 10:11 AM
 */

namespace Wagento\SearchModified\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption ;
use Symfony\Component\Console\Output\OutputInterface;
use Wagento\SearchModified\Helper\Data;
class Modified extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @param Data $helper
     */
    public function __construct(Data $helper, $name = null)
    {
        parent::__construct($name);
        $this->helper = $helper;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('wagento:modified')
            ->setDescription('Search Modified Files');
        $this->addOption( 'days', 'days', InputOption::VALUE_REQUIRED, 'Number Of Days', null)
           ->addOption( 'dir', 'dir', InputOption::VALUE_REQUIRED, 'Directory path e.g. app/code/local', null)
           ->addOption( 'ext', 'ext', InputOption::VALUE_REQUIRED, 
            'File extensions, Enter file extensions. e.g. php / For multiple file types e.g. php,phtml', null);
       return parent::configure();
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $days = $input->getOption('days');
        $directory = $input->getOption('dir');
        $extensions = $input->getOption('ext');
        $result = $this->helper->searchModified($days, $directory, $extensions);
        $output->write("\n");
        foreach ($result as $key => $value) {
            $output->writeln($value);
        }
        return 0;
    }
}