<?php
namespace Example {

use \OtherPackage\Confublator;
use \OtherPackage\Intradicator;
	
	interface ExampleInterface {
		public function doStuff(): string;
	}
	abstract class ExampleAbstract implements ExampleInterface {
		public static function prepareStuff(int $count): void {
		
		}
	}
	class ExampleClass extends ExampleAbstract {
		protected Confublator $conf;
		protected int $count;
		public function doStuff(Intradicator $int): string {
		
		}
	}
}
namespace OtherPackage {
	class Confublator {
		private \Exception $exception;
	}
	class Intradicator {
		protected int $sum;
	}
}