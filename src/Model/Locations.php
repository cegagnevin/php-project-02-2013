<?php
	namespace Model;
	class Locations implements FinderInterface, PersistenceInterface
	{	
		private $_locations;

		private $_file;

		public function __construct()
		{
			$this->_file = __DIR__ ."/data/locations.json";
			/*
			$this->_locations = array("San Francisco",
			 			"Paris",
						"New york",
						"Berlin",
						"Bamako",
						"Buenos Aires",
						"Santiago",
						"Bombay",
						"Vancouver",
			  );
			  
			file_put_contents($this->_file, json_encode($this->_locations));
			*/
			
			$this->_locations = json_decode(file_get_contents($this->_file),  true);
		}

		/**
		* Returns all elements.
		*
		* @return array
		*/
		public function findAll()	
		{
			return $this->_locations;
		}

		/**
		* Retrieve an element by its id.
		*
		* @param  mixed      $id
		* @return null|mixed
		*/
		public function findOneById($id)
        {
            if($id > count($this->_locations))
            {
				$maxCitiesIndex = count($this->_locations) -1 ; 
				//launch an httpException
                throw new \Exception\HttpException(404, "Il n'y a actuellement que ".count($this->_locations)." villes !<br/>Veuillez choisir un identifiant compris entre 0 et ".$maxCitiesIndex.".");
            }
			
			return $this->_locations[$id];
		}
		
		/**
		* Create a new location
		*
		*/
		public function create($name)
		{
			$this->_locations[] = $name;
			
			//put into the file
			file_put_contents($this->_file, json_encode($this->_locations));
		}

		/**
		* Delete a new location
		*
		*/
		public function delete($id)
		{
			unset($this->_locations[$id]);
			
			//put into the file
			file_put_contents($this->_file, json_encode($this->_locations));
		}


		/**
		* Update a new location
		*
		*/
		public function update($id, $name)
		{
			$this->_locations[$id] = $name;
			echo "id : ".$id."<br/>Name : ".$name."<br/>";
			//put into the file
			file_put_contents($this->_file, json_encode($this->_locations));
		}
	}
