<?php declare(strict_types=1);

namespace Symplify\BetterPhpDocParser\Tests\PhpDocParser;

use Symplify\BetterPhpDocParser\PhpDocParser\PhpDocInfo;
use Symplify\BetterPhpDocParser\PhpDocParser\PhpDocInfoFactory;
use Symplify\BetterPhpDocParser\Tests\AbstractContainerAwareTestCase;

final class PhpDocInfoTest extends AbstractContainerAwareTestCase
{
    /**
     * @var PhpDocInfo
     */
    private $phpDocInfo;

    protected function setUp(): void
    {
        /** @var PhpDocInfoFactory $phpDocInfoFactory */
        $phpDocInfoFactory = $this->container->get(PhpDocInfoFactory::class);

        $this->phpDocInfo = $phpDocInfoFactory->createFrom(file_get_contents(__DIR__ . '/PhpDocInfoSource/doc.txt'));
    }

    public function testHasTag(): void
    {
        $this->assertTrue($this->phpDocInfo->hasTag('param'));
        $this->assertTrue($this->phpDocInfo->hasTag('@throw'));

        $this->assertFalse($this->phpDocInfo->hasTag('random'));
    }

    public function testGetTagsByName(): void
    {
        $paramTags = $this->phpDocInfo->getTagsByName('param');
        $this->assertCount(2, $paramTags);
    }
}
