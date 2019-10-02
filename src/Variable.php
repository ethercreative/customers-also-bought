<?php
/**
 * Purchase Patterns
 *
 * @link      https://ethercreative.co.uk
 * @copyright Copyright (c) Ether Creative
 */

namespace ether\purchasePatterns;

use Craft;
use craft\commerce\elements\db\ProductQuery;
use craft\commerce\elements\Order;
use craft\commerce\elements\Product;
use ether\purchasePatterns\elements\db\ProductQueryExtended;
use yii\base\InvalidConfigException;
use yii\db\Exception;


/**
 * Class Variable
 *
 * @author  Ether Creative
 * @package ether\purchasePatterns
 * @since   1.0.0
 */
class Variable
{

	/**
	 * Finds any relayed products for the given product
	 *
	 * TODO: Add ability to exclude products or orders from the returned results
	 *
	 * @param Product|Order     $target
	 * @param int               $limit
	 * @param bool              $includeAll
	 * @param ProductQuery|null $paddingQuery
	 *
	 * @return ProductQuery
	 * @throws InvalidConfigException
	 * @throws Exception
	 */
	public function related (
		$target,
		$limit = 8,
		$includeAll = true,
		ProductQuery $paddingQuery = null
	) {
		$service = PurchasePatterns::getInstance()->getService();

		if ($target instanceof Product)
		{
			return $service->getRelatedToProductCriteria(
				$target,
				$limit,
				$includeAll,
				$paddingQuery
			);
		}

		if ($target instanceof Order)
		{
			return $service->getRelatedToOrderCriteria(
				$target,
				$limit,
				$includeAll,
				$paddingQuery
			);
		}

		throw new InvalidConfigException(
			"The target passed to craft.purchasePatterns.related is not a valid order or product"
		);
	}

	/**
	 * Returns an extended product query
	 *
	 * @param mixed|null $criteria
	 *
	 * @return ProductQueryExtended
	 */
	public function extended ($criteria = null)
	{
		$query = new ProductQueryExtended(Product::class);

		if ($criteria)
			Craft::configure($query, $criteria);

		return $query;
	}

}
