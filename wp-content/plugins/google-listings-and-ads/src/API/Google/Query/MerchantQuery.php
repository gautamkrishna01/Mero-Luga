<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\API\Google\Query;

use Automattic\WooCommerce\GoogleListingsAndAds\Exception\InvalidProperty;
use Automattic\WooCommerce\GoogleListingsAndAds\Vendor\Google\Exception as GoogleException;
use Automattic\WooCommerce\GoogleListingsAndAds\Vendor\Google\Service\ShoppingContent;
use Automattic\WooCommerce\GoogleListingsAndAds\Vendor\Google\Service\ShoppingContent\SearchRequest;
use Automattic\WooCommerce\GoogleListingsAndAds\Vendor\Google\Service\ShoppingContent\SearchResponse;

defined( 'ABSPATH' ) || exit;

/**
 * Class MerchantQuery
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds\API\Google\Query
 */
abstract class MerchantQuery extends Query {

	/**
	 * Client which handles the query.
	 *
	 * @var ShoppingContent
	 */
	protected $client = null;

	/**
	 * Merchant Account ID.
	 *
	 * @var int
	 */
	protected $id = null;

	/**
	 * Arguments to add to the search query.
	 *
	 * @var array
	 */
	protected $search_args = [];

	/**
	 * Set the client which will handle the query.
	 *
	 * @param ShoppingContent $client Client instance.
	 * @param int             $id     Account ID.
	 *
	 * @return QueryInterface
	 */
	public function set_client( ShoppingContent $client, int $id ): QueryInterface {
		$this->client = $client;
		$this->id     = $id;

		return $this;
	}

	/**
	 * Perform the query and save it to the results.
	 *
	 * @throws GoogleException If the search call fails.
	 * @throws InvalidProperty If the client is not set.
	 */
	protected function query_results() {
		if ( ! $this->client || ! $this->id ) {
			throw InvalidProperty::not_null( get_class( $this ), 'client' );
		}

		$request = new SearchRequest();
		$request->setQuery( $this->build_query() );

		if ( ! empty( $this->search_args['pageSize'] ) ) {
			$request->setPageSize( $this->search_args['pageSize'] );
		}

		if ( ! empty( $this->search_args['pageToken'] ) ) {
			$request->setPageToken( $this->search_args['pageToken'] );
		}

		/** @var SearchResponse $this->results */
		$results = $this->client->reports->search( $this->id, $request );

		/**
		 * Filter the search response prior to setting the property.
		 *
		 * @param SearchResponse $results The search response.
		 * @param SearchRequest  $request The search request.
		 */
		$this->results = apply_filters( 'gla_merchant_query_response', $results, $request );
	}
}
