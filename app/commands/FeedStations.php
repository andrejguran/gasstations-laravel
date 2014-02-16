<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use CeskyBenzin\Feed;

class FeedStations extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'FeedStations';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$feed = new Feed;
		$this->info('Getting stations data');
		$numStations = $feed->getStationsData();

		$this->info("Obtained info about {$numStations} stations");

		$stations = $feed->getStations();

		ksort($stations);

		$position = array_search($this->option('start'), array_keys($stations));
		$stations = array_slice($stations, $position);

		$numFeedStations = count($stations);
		foreach ($stations as $id => $station)
		{
			$fuel = $this->option('fuel');
			$this->info("Feeding station cbid: {$station['cbid']} with fuel - {$fuel} ({$id}/{$numFeedStations})");
			$numEntries = $feed->feedStation($station['cbid'], $fuel);
			$this->info("Entries added: {$numEntries}");
		}

		$this->info('End of a feed');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('start', 's', InputOption::VALUE_OPTIONAL, 'Starting cbid', 1),
			array('fuel', 'f', InputOption::VALUE_OPTIONAL, 'Type of fuel (1 - Natural 95, 3 - Diesel)', 1),
		);
	}

}