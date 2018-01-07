<?php

namespace Mastering\SampleModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action {
	public function execute(){
		/** @var Raw $result */
		$result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
		$result->setContents('Hello World!');
		return $result;
	}
}