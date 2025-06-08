<?php

use App\Services\AliasMaker\Docker\Docker;
use PHPUnit\Framework\TestCase;

class DockerTest extends TestCase
{
    private string $tempHome;

    protected function setUp(): void
    {
        $this->tempHome = sys_get_temp_dir().'/fake_home_'.uniqid();
        mkdir($this->tempHome);

        putenv("HOME={$this->tempHome}");
        $_SERVER['HOME'] = $this->tempHome;
    }

    protected function tearDown(): void
    {
        $aliasFile = $this->tempHome.'/.docker_aliases.sh';
        if (file_exists($aliasFile)) {
            unlink($aliasFile);
        }
        $this->_deleteDirectory($this->tempHome);
        putenv('HOME');
        unset($_SERVER['HOME']);
    }

    public function test_generate_alias_file_creates_file_when_missing()
    {
        $docker = new Docker;
        $aliasFilePath = $this->tempHome.'/.devx_docker_aliases';
        $this->assertFileDoesNotExist($aliasFilePath);
        $docker->generateAliasFile();
        $this->assertFileExists($aliasFilePath);
        $expectedContent = file_get_contents(\App\Utils\Path::resourcePath('/aliases/.docker_aliases.sh'));
        $actualContent = file_get_contents($aliasFilePath);
        $this->assertEquals($expectedContent, $actualContent);
    }

    public function test_generate_alias_file_does_not_overwrite_existing_file()
    {
        $aliasFilePath = $this->tempHome.'/.docker_aliases.sh';
        file_put_contents($aliasFilePath, 'something');
        $docker = new Docker;
        $docker->generateAliasFile();
        $this->assertStringEqualsFile($aliasFilePath, 'something');
    }

    private function _deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir.DIRECTORY_SEPARATOR.$file;
            is_dir($path) ? $this->_deleteDirectory($path) : unlink($path);
        }

        rmdir($dir);
    }
}
