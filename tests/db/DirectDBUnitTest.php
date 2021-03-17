<?php
use PHPUnit\Framework\TestCase;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Config;
 
class DisallowExtractSniffTest extends TestCase {
	public function test_unsafe_code() {
		$fixtureFile = __FILE__ . '-bad.inc';
		$sniffFiles = [ dirname( dirname( __DIR__ ) ) . '/MinimalPluginStandard/Sniffs/DirectDBSniff.php' ];
		$config = new Config();
		$ruleset = new Ruleset($config);
		$ruleset->registerSniffs($sniffFiles, [], []);
		$ruleset->populateTokenListeners();
		$phpcsFile = new LocalFile($fixtureFile, $ruleset, $config);
		$phpcsFile->process();
		$foundErrors = $phpcsFile->getErrors();
		var_dump( $foundErrors[ 328 ] );
		$error_lines = array_keys($foundErrors);

		$this->assertEquals(
			[
				14,
				22,
				30,
				38,
				45,
				52,
				59,
				66,
				75,
				82,
				97,
				106,
				113,
				120,
				140,
				159,
				168,
				181,
				200,
				221,
				258,
				270,
				292,
				310,
				316,
				328,
			], 
			$error_lines );

		$warning_lines = array_keys( $phpcsFile->getWarnings() );
		$this->assertEquals(
			[
				89,
				149,
				188,
				191,
				196,
				203,
				207,
				278,
				279,
				280,
				281,
				301
			],
			$warning_lines );

	}

	public function test_safe_code() {
		$fixtureFile = __FILE__ . '-safe.inc';
		$sniffFiles = [ dirname( dirname( __DIR__ ) ) . '/MinimalPluginStandard/Sniffs/DirectDBSniff.php' ];
		$config = new Config();
		$ruleset = new Ruleset($config);
		$ruleset->registerSniffs($sniffFiles, [], []);
		$ruleset->populateTokenListeners();
		$phpcsFile = new LocalFile($fixtureFile, $ruleset, $config);
		$phpcsFile->process();
		$foundErrors = $phpcsFile->getErrors();
		$lines = array_keys($foundErrors);

		$this->assertEquals(
			[],
			$lines);
	}
}