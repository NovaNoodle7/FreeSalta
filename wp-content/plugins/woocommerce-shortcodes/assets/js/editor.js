/*global tinymce */
( function () {

	/**
	 * Check is empty.
	 *
	 * @param  {string} value
	 * @return {bool}
	 */
	function wcShortcodesIsEmpty( value ) {
		value = value.toString();

		if ( 0 !== value.length ) {
			return false;
		}

		return true;
	}

	/**
	 * Add the shortcodes downdown.
	 */
	tinymce.PluginManager.add( 'woocommerce_shortcodes', function ( editor ) {
		var ed = tinymce.activeEditor;
		editor.addButton( 'woocommerce_shortcodes', {
			text: ed.getLang( 'woocommerce_shortcodes.shortcode_title' ),
			icon: 'woocommerce-shortcodes',
			type: 'menubutton',
			menu: [
				{
					text: ed.getLang( 'woocommerce_shortcodes.product' ),
					menu: [
						{
							text: ed.getLang( 'woocommerce_shortcodes.add_to_cart' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.product' ) + ' ' + ed.getLang( 'woocommerce_shortcodes.add_to_cart' ),
									body: [
										{
											type:  'textbox',
											name:  'id',
											label: ed.getLang( 'woocommerce_shortcodes.id' )
										},
										{
											type:  'textbox',
											name:  'sku',
											label: ed.getLang( 'woocommerce_shortcodes.sku' )
										},
										{
											type:  'textbox',
											name:  'style',
											label: ed.getLang( 'woocommerce_shortcodes.style' )
										},
										{
											type:    'checkbox',
											name:    'show_price',
											label:   ed.getLang( 'woocommerce_shortcodes.show_price' ),
											checked: true
										}
									],
									onsubmit: function ( e ) {
										var id         = wcShortcodesIsEmpty( e.data.id ) ? '' : ' id="' + e.data.id + '"',
											sku        = wcShortcodesIsEmpty( e.data.sku ) ? '' : ' sku="' + e.data.sku + '"',
											style      = wcShortcodesIsEmpty( e.data.style ) ? '' : ' style="' + e.data.style + '"',
											show_price = e.data.show_price ? '' : ' show_price="' + e.data.show_price + '"';

										if ( ! wcShortcodesIsEmpty( e.data.id ) || ! wcShortcodesIsEmpty( e.data.sku ) ) {
											editor.insertContent( '[add_to_cart' + id + sku + style + show_price + ']' );
										} else {
											editor.windowManager.alert( ed.getLang( 'woocommerce_shortcodes.need_id_or_sku' ) );
										}
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.add_to_cart_url' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.product' ) + ' ' + ed.getLang( 'woocommerce_shortcodes.add_to_cart_url' ),
									body: [
										{
											type:  'textbox',
											name:  'id',
											label: ed.getLang( 'woocommerce_shortcodes.id' )
										},
										{
											type:  'textbox',
											name:  'sku',
											label: ed.getLang( 'woocommerce_shortcodes.sku' )
										}
									],
									onsubmit: function ( e ) {
										var id         = wcShortcodesIsEmpty( e.data.id ) ? '' : ' id="' + e.data.id + '"',
											sku        = wcShortcodesIsEmpty( e.data.sku ) ? '' : ' sku="' + e.data.sku + '"';

										if ( ! wcShortcodesIsEmpty( e.data.id ) || ! wcShortcodesIsEmpty( e.data.sku ) ) {
											editor.insertContent( '[add_to_cart_url' + id + sku + ']' );
										} else {
											editor.windowManager.alert( ed.getLang( 'woocommerce_shortcodes.need_id_or_sku' ) );
										}
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.product_by_sku' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.product' ) + ' ' + ed.getLang( 'woocommerce_shortcodes.product_by_sku' ),
									body: [
										{
											type:  'textbox',
											name:  'id',
											label: ed.getLang( 'woocommerce_shortcodes.id' )
										},
										{
											type:  'textbox',
											name:  'sku',
											label: ed.getLang( 'woocommerce_shortcodes.sku' )
										}
									],
									onsubmit: function ( e ) {
										var id  = wcShortcodesIsEmpty( e.data.id ) ? '' : ' id="' + e.data.id + '"',
											sku = wcShortcodesIsEmpty( e.data.sku ) ? '' : ' sku="' + e.data.sku + '"';

										if ( ! wcShortcodesIsEmpty( e.data.id ) || ! wcShortcodesIsEmpty( e.data.sku ) ) {
											editor.insertContent( '[product' + id + sku + ']' );
										} else {
											editor.windowManager.alert( ed.getLang( 'woocommerce_shortcodes.need_id_or_sku' ) );
										}
									}
								});
							}
						}
					]
				},
				{
					text: ed.getLang( 'woocommerce_shortcodes.list' ),
					menu: [
						{
							text: ed.getLang( 'woocommerce_shortcodes.products_by_sku' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.product_by_sku' ),
									body: [
										{
											type:   'textbox',
											name:   'ids',
											label:   ed.getLang( 'woocommerce_shortcodes.ids' ),
											tooltip: ed.getLang( 'woocommerce_shortcodes.comma_tooltip' )
										},
										{
											type:    'textbox',
											name:    'skus',
											label:   ed.getLang( 'woocommerce_shortcodes.skus' ),
											tooltip: ed.getLang( 'woocommerce_shortcodes.comma_tooltip' )
										}
									],
									onsubmit: function ( e ) {
										var ids  = wcShortcodesIsEmpty( e.data.ids ) ? '' : ' ids="' + e.data.ids + '"',
											skus = wcShortcodesIsEmpty( e.data.skus ) ? '' : ' skus="' + e.data.skus + '"';

										if ( ! wcShortcodesIsEmpty( e.data.ids ) || ! wcShortcodesIsEmpty( e.data.skus ) ) {
											editor.insertContent( '[products' + ids + skus + ']' );
										} else {
											editor.windowManager.alert( ed.getLang( 'woocommerce_shortcodes.need_id_or_sku' ) );
										}
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.product_categories' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.product_categories' ),
									body: [
										{
											type:  'textbox',
											name:  'number',
											label: ed.getLang( 'woocommerce_shortcodes.number' )
										},
										{
											type:   'listbox',
											name:   'orderby',
											label:  ed.getLang( 'woocommerce_shortcodes.orderby' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.name' ),
													value: 'name'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.id' ),
													value: 'id'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.count' ),
													value: 'count'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.slug' ),
													value: 'slug'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.none' ),
													value: 'none'
												}
											]
										},
										{
											type:   'listbox',
											name:   'order',
											label:  ed.getLang( 'woocommerce_shortcodes.order' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.asc' ),
													value: 'ASC'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.desc' ),
													value: 'DESC'
												}
											]
										},
										{
											type:  'textbox',
											name:  'columns',
											label: ed.getLang( 'woocommerce_shortcodes.columns' )
										},
										{
											type:    'checkbox',
											name:    'hide_empty',
											label:   ed.getLang( 'woocommerce_shortcodes.hide_empty' ),
											checked: true
										},
										{
											type:  'textbox',
											name:  'parent_id',
											label: ed.getLang( 'woocommerce_shortcodes.parent_id' )
										},
										{
											type:    'textbox',
											name:    'ids',
											label:   ed.getLang( 'woocommerce_shortcodes.ids' ),
											tooltip: ed.getLang( 'woocommerce_shortcodes.comma_tooltip' )
										}
									],
									onsubmit: function ( e ) {
										var number     = wcShortcodesIsEmpty( e.data.number ) ? '' : ' number="' + e.data.number + '"',
											columns    = wcShortcodesIsEmpty( e.data.columns ) ? '' : ' columns="' + e.data.columns + '"',
											hide_empty = e.data.hide_empty ? '' : ' hide_empty="' + e.data.hide_empty + '"',
											parent_id  = wcShortcodesIsEmpty( e.data.parent_id ) ? '' : ' parent="' + e.data.parent_id + '"',
											ids        = wcShortcodesIsEmpty( e.data.ids ) ? '' : ' ids="' + e.data.ids + '"';

										editor.insertContent( '[product_categories' + number + columns + ' orderby="' + e.data.orderby + '" order="' + e.data.order + '"' + hide_empty + parent_id + ids + ']' );
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.products_by_cat_slug' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.products_by_cat_slug' ),
									body: [
										{
											type:  'textbox',
											name:  'category_slug',
											label: ed.getLang( 'woocommerce_shortcodes.category_slug' )
										},
										{
											type:  'textbox',
											name:  'per_page',
											label: ed.getLang( 'woocommerce_shortcodes.categories_per_page' ),
											value: '12'
										},
										{
											type:  'textbox',
											name:  'columns',
											label: ed.getLang( 'woocommerce_shortcodes.columns' ),
											value: '4'
										},
										{
											type:   'listbox',
											name:   'orderby',
											label:  ed.getLang( 'woocommerce_shortcodes.orderby' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.default' ),
													value: 'default'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.rand' ),
													value: 'rand'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.date' ),
													value: 'date'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.price' ),
													value: 'price'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.popularity' ),
													value: 'popularity'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.rating' ),
													value: 'rating'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.title' ),
													value: 'title'
												}
											]
										},
										{
											type:   'listbox',
											name:   'order',
											label:  ed.getLang( 'woocommerce_shortcodes.order' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.asc' ),
													value: 'ASC'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.desc' ),
													value: 'DESC'
												}
											]
										},
										{
											type:   'listbox',
											name:   'operator',
											label:  ed.getLang( 'woocommerce_shortcodes.operator' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.in' ),
													value: 'IN'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.not_in' ),
													value: 'NOT IN'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.and' ),
													value: 'AND'
												}
											]
										}
									],
									onsubmit: function ( e ) {
										var category = wcShortcodesIsEmpty( e.data.category_slug ) ? '' : ' category="' + e.data.category_slug + '"';

										if ( ! wcShortcodesIsEmpty( e.data.category_slug ) ) {
											editor.insertContent( '[product_category' + category + ' per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '" operator="' + e.data.operator + '"]' );
										} else {
											editor.windowManager.alert( ed.getLang( 'woocommerce_shortcodes.need_category_slug' ) );
										}
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.products_by_attribute' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.products_by_attribute' ),
									body: [
										{
											type:  'textbox',
											name:  'attribute_slug',
											label: ed.getLang( 'woocommerce_shortcodes.attribute_slug' )
										},
										{
											type:    'textbox',
											name:    'terms_slug',
											label:   ed.getLang( 'woocommerce_shortcodes.terms_slug' ),
											tooltip: ed.getLang( 'woocommerce_shortcodes.comma_tooltip' )
										},
										{
											type:  'textbox',
											name:  'per_page',
											label: ed.getLang( 'woocommerce_shortcodes.products_per_page' ),
											value: '12'
										},
										{
											type:  'textbox',
											name:  'columns',
											label: ed.getLang( 'woocommerce_shortcodes.columns' ),
											value: '4'
										},
										{
											type:   'listbox',
											name:   'orderby',
											label:  ed.getLang( 'woocommerce_shortcodes.orderby' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.date' ),
													value: 'date'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.rand' ),
													value: 'rand'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.title' ),
													value: 'title'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.none' ),
													value: 'none'
												}
											]
										},
										{
											type:   'listbox',
											name:   'order',
											label:  ed.getLang( 'woocommerce_shortcodes.order' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.asc' ),
													value: 'ASC'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.desc' ),
													value: 'DESC'
												}
											]
										}
									],
									onsubmit: function ( e ) {
										if ( ! wcShortcodesIsEmpty( e.data.attribute_slug ) && ! wcShortcodesIsEmpty( e.data.terms_slug ) ) {
											editor.insertContent( '[product_attribute attribute="' + e.data.attribute_slug + '" filter="' + e.data.terms_slug + '" per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]' );
										} else {
											editor.windowManager.alert( ed.getLang( 'woocommerce_shortcodes.need_attribute_and_terms_slugs' ) );
										}
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.recent_products' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.recent_products' ),
									body: [
										{
											type:  'textbox',
											name:  'per_page',
											label: ed.getLang( 'woocommerce_shortcodes.products_per_page' ),
											value: '12'
										},
										{
											type:  'textbox',
											name:  'columns',
											label: ed.getLang( 'woocommerce_shortcodes.columns' ),
											value: '4'
										},
										{
											type:   'listbox',
											name:   'orderby',
											label:  ed.getLang( 'woocommerce_shortcodes.orderby' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.date' ),
													value: 'date'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.rand' ),
													value: 'rand'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.title' ),
													value: 'title'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.none' ),
													value: 'none'
												}
											]
										},
										{
											type:   'listbox',
											name:   'order',
											label:  ed.getLang( 'woocommerce_shortcodes.order' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.asc' ),
													value: 'ASC'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.desc' ),
													value: 'DESC'
												}
											]
										}
									],
									onsubmit: function ( e ) {
										editor.insertContent( '[recent_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]' );
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.featured_products' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.featured_products' ),
									body: [
										{
											type:  'textbox',
											name:  'per_page',
											label: ed.getLang( 'woocommerce_shortcodes.products_per_page' ),
											value: '12'
										},
										{
											type:  'textbox',
											name:  'columns',
											label: ed.getLang( 'woocommerce_shortcodes.columns' ),
											value: '4'
										},
										{
											type:   'listbox',
											name:   'orderby',
											label:  ed.getLang( 'woocommerce_shortcodes.orderby' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.date' ),
													value: 'date'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.rand' ),
													value: 'rand'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.title' ),
													value: 'title'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.none' ),
													value: 'none'
												}
											]
										},
										{
											type:   'listbox',
											name:   'order',
											label:  ed.getLang( 'woocommerce_shortcodes.order' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.asc' ),
													value: 'ASC'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.desc' ),
													value: 'DESC'
												}
											]
										}
									],
									onsubmit: function ( e ) {
										editor.insertContent( '[featured_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]' );
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.sale_products' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.sale_products' ),
									body: [
										{
											type:  'textbox',
											name:  'per_page',
											label: ed.getLang( 'woocommerce_shortcodes.products_per_page' ),
											value: '12'
										},
										{
											type:  'textbox',
											name:  'columns',
											label: ed.getLang( 'woocommerce_shortcodes.columns' ),
											value: '4'
										},
										{
											type:   'listbox',
											name:   'orderby',
											label:  ed.getLang( 'woocommerce_shortcodes.orderby' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.date' ),
													value: 'date'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.rand' ),
													value: 'rand'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.title' ),
													value: 'title'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.none' ),
													value: 'none'
												}
											]
										},
										{
											type:   'listbox',
											name:   'order',
											label:  ed.getLang( 'woocommerce_shortcodes.order' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.asc' ),
													value: 'ASC'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.desc' ),
													value: 'DESC'
												}
											]
										}
									],
									onsubmit: function ( e ) {
										editor.insertContent( '[sale_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]' );
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.best_selling_products' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.best_selling_products' ),
									body: [
										{
											type:  'textbox',
											name:  'per_page',
											label: ed.getLang( 'woocommerce_shortcodes.products_per_page' ),
											value: '12'
										},
										{
											type:  'textbox',
											name:  'columns',
											label: ed.getLang( 'woocommerce_shortcodes.columns' ),
											value: '4'
										},
										{
											type:   'listbox',
											name:   'orderby',
											label:  ed.getLang( 'woocommerce_shortcodes.orderby' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.date' ),
													value: 'date'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.rand' ),
													value: 'rand'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.title' ),
													value: 'title'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.none' ),
													value: 'none'
												}
											]
										},
										{
											type:   'listbox',
											name:   'order',
											label:  ed.getLang( 'woocommerce_shortcodes.order' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.asc' ),
													value: 'ASC'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.desc' ),
													value: 'DESC'
												}
											]
										}
									],
									onsubmit: function ( e ) {
										editor.insertContent( '[best_selling_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]' );
									}
								});
							}
						},
						{
							text: ed.getLang( 'woocommerce_shortcodes.top_rated_products' ),
							onclick: function () {
								editor.windowManager.open({
									title: ed.getLang( 'woocommerce_shortcodes.top_rated_products' ),
									body: [
										{
											type:  'textbox',
											name:  'per_page',
											label: ed.getLang( 'woocommerce_shortcodes.products_per_page' ),
											value: '12'
										},
										{
											type:  'textbox',
											name:  'columns',
											label: ed.getLang( 'woocommerce_shortcodes.columns' ),
											value: '4'
										},
										{
											type:   'listbox',
											name:   'orderby',
											label:  ed.getLang( 'woocommerce_shortcodes.orderby' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.date' ),
													value: 'date'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.rand' ),
													value: 'rand'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.title' ),
													value: 'title'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.none' ),
													value: 'none'
												}
											]
										},
										{
											type:   'listbox',
											name:   'order',
											label:  ed.getLang( 'woocommerce_shortcodes.order' ),
											values: [
												{
													text: ed.getLang( 'woocommerce_shortcodes.asc' ),
													value: 'ASC'
												},
												{
													text: ed.getLang( 'woocommerce_shortcodes.desc' ),
													value: 'DESC'
												}
											]
										}
									],
									onsubmit: function ( e ) {
										editor.insertContent( '[top_rated_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]' );
									}
								});
							}
						}
					]
				},
				{
					text: ed.getLang( 'woocommerce_shortcodes.shop_messages' ),
					onclick: function () {
						editor.insertContent( '[' + ed.getLang( 'woocommerce_shortcodes.shop_messages_shortcode' ) + ']' );
					}
				},
				{
					text: ed.getLang( 'woocommerce_shortcodes.order_tracking' ),
					onclick: function () {
						editor.insertContent( '[' + ed.getLang( 'woocommerce_shortcodes.order_tracking_shortcode' ) + ']' );
					}
				}
			]
		});
	});
})();
