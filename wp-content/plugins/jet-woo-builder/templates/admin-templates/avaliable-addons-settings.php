<div
	class="jet-woo-builder-settings-page jet-woo-builder-settings-page__avaliable-addons"
>
	<div class="avaliable-widgets">
		<div class="avaliable-widgets__option-info">
			<div class="avaliable-widgets__option-info-name"><?php _e( 'Global Widgets', 'jet-woo-builder' ); ?></div>
			<div class="avaliable-widgets__option-info-desc"><?php _e( 'These widgets will be available when editing the shop page', 'jet-woo-builder' ); ?></div>
		</div>
		<div class="avaliable-widgets__controls">
			<div
				class="avaliable-widgets__control"
				v-for="(option, index) in pageOptions.global_available_widgets.options"
			>
				<cx-vui-switcher
					:key="index"
					:name="`global-avaliable-widget-${option.value}`"
					:label="option.label"
					:wrapper-css="[ 'equalwidth' ]"
					return-true="true"
					return-false="false"
					v-model="pageOptions.global_available_widgets.value[option.value]"
				>
				</cx-vui-switcher>
			</div>
		</div>
	</div>

	<div class="avaliable-widgets">
		<div class="avaliable-widgets__option-info">
			<div class="avaliable-widgets__option-info-name"><?php _e( 'Single Product Widgets', 'jet-woo-builder' ); ?></div>
			<div class="avaliable-widgets__option-info-desc"><?php _e( 'These widgets will be available when editing the product single template', 'jet-woo-builder' ); ?></div>
		</div>
		<div class="avaliable-widgets__controls">
			<div
				class="avaliable-widgets__control"
				v-for="(option, index) in pageOptions.single_product_available_widgets.options"
			>
				<cx-vui-switcher
					:key="index"
					:name="`single-product-avaliable-widget-${option.value}`"
					:label="option.label"
					:wrapper-css="[ 'equalwidth' ]"
					return-true="true"
					return-false="false"
					v-model="pageOptions.single_product_available_widgets.value[option.value]"
				>
				</cx-vui-switcher>
			</div>
		</div>
	</div>

	<div class="avaliable-widgets">
		<div class="avaliable-widgets__option-info">
			<div class="avaliable-widgets__option-info-name"><?php _e( 'Archive Product Widgets', 'jet-woo-builder' ); ?></div>
			<div class="avaliable-widgets__option-info-desc"><?php _e( 'These widgets will be available when editing the archive product template', 'jet-woo-builder' ); ?></div>
		</div>
		<div class="avaliable-widgets__controls">
			<div
				class="avaliable-widgets__control"
				v-for="(option, index) in pageOptions.archive_product_available_widgets.options"
			>
				<cx-vui-switcher
					:key="index"
					:name="`archive-product-avaliable-widget-${option.value}`"
					:label="option.label"
					:wrapper-css="[ 'equalwidth' ]"
					return-true="true"
					return-false="false"
					v-model="pageOptions.archive_product_available_widgets.value[option.value]"
				>
				</cx-vui-switcher>
			</div>
		</div>
	</div>

	<div class="avaliable-widgets">
		<div class="avaliable-widgets__option-info">
			<div class="avaliable-widgets__option-info-name"><?php _e( 'Archive Category Widgets', 'jet-woo-builder' ); ?></div>
			<div class="avaliable-widgets__option-info-desc"><?php _e( 'These widgets will be available when editing the archive category template', 'jet-woo-builder' ); ?></div>
		</div>
		<div class="avaliable-widgets__controls">
			<div
				class="avaliable-widgets__control"
				v-for="(option, index) in pageOptions.archive_category_available_widgets.options"
			>
				<cx-vui-switcher
					:key="index"
					:name="`archive-category-avaliable-widget-${option.value}`"
					:label="option.label"
					:wrapper-css="[ 'equalwidth' ]"
					return-true="true"
					return-false="false"
					v-model="pageOptions.archive_category_available_widgets.value[option.value]"
				>
				</cx-vui-switcher>
			</div>
		</div>
	</div>

	<div class="avaliable-widgets">
		<div class="avaliable-widgets__option-info">
			<div class="avaliable-widgets__option-info-name"><?php _e( 'Shop Product Widgets', 'jet-woo-builder' ); ?></div>
			<div class="avaliable-widgets__option-info-desc"><?php _e( 'These widgets will be available when editing the archive product template', 'jet-woo-builder' ); ?></div>
		</div>
		<div class="avaliable-widgets__controls">
			<div
				class="avaliable-widgets__control"
				v-for="(option, index) in pageOptions.shop_product_available_widgets.options"
			>
				<cx-vui-switcher
					:key="index"
					:name="`shop-product-avaliable-widget-${option.value}`"
					:label="option.label"
					:wrapper-css="[ 'equalwidth' ]"
					return-true="true"
					return-false="false"
					v-model="pageOptions.shop_product_available_widgets.value[option.value]"
				>
				</cx-vui-switcher>
			</div>
		</div>
	</div>

	<div class="avaliable-widgets">
		<div class="avaliable-widgets__option-info">
			<div class="avaliable-widgets__option-info-name"><?php _e( 'Cart Widgets', 'jet-woo-builder' ); ?></div>
			<div class="avaliable-widgets__option-info-desc"><?php _e( 'These widgets will be available when editing the cart template', 'jet-woo-builder' ); ?></div>
		</div>
		<div class="avaliable-widgets__controls">
			<div
				class="avaliable-widgets__control"
				v-for="(option, index) in pageOptions.cart_available_widgets.options"
			>
				<cx-vui-switcher
					:key="index"
					:name="`cart-avaliable-widget-${option.value}`"
					:label="option.label"
					:wrapper-css="[ 'equalwidth' ]"
					return-true="true"
					return-false="false"
					v-model="pageOptions.cart_available_widgets.value[option.value]"
				>
				</cx-vui-switcher>
			</div>
		</div>
	</div>

	<div class="avaliable-widgets">
		<div class="avaliable-widgets__option-info">
			<div class="avaliable-widgets__option-info-name"><?php _e( 'Checkout Widgets', 'jet-woo-builder' ); ?></div>
			<div class="avaliable-widgets__option-info-desc"><?php _e( 'These widgets will be available when editing the checkout template', 'jet-woo-builder' ); ?></div>
		</div>
		<div class="avaliable-widgets__controls">
			<div
				class="avaliable-widgets__control"
				v-for="(option, index) in pageOptions.checkout_available_widgets.options"
			>
				<cx-vui-switcher
					:key="index"
					:name="`checkout-avaliable-widget-${option.value}`"
					:label="option.label"
					:wrapper-css="[ 'equalwidth' ]"
					return-true="true"
					return-false="false"
					v-model="pageOptions.checkout_available_widgets.value[option.value]"
				>
				</cx-vui-switcher>
			</div>
		</div>
	</div>

	<div class="avaliable-widgets">
		<div class="avaliable-widgets__option-info">
			<div class="avaliable-widgets__option-info-name"><?php _e( 'Thank You Page Widgets', 'jet-woo-builder' ); ?></div>
			<div class="avaliable-widgets__option-info-desc"><?php _e( 'These widgets will be available when editing the thank you page template', 'jet-woo-builder' ); ?></div>
		</div>
		<div class="avaliable-widgets__controls">
			<div
				class="avaliable-widgets__control"
				v-for="(option, index) in pageOptions.thankyou_available_widgets.options"
			>
				<cx-vui-switcher
						:key="index"
						:name="`thankyou-avaliable-widget-${option.value}`"
						:label="option.label"
						:wrapper-css="[ 'equalwidth' ]"
						return-true="true"
						return-false="false"
						v-model="pageOptions.thankyou_available_widgets.value[option.value]"
				>
				</cx-vui-switcher>
			</div>
		</div>
	</div>

	<div class="avaliable-widgets">
		<div class="avaliable-widgets__option-info">
			<div class="avaliable-widgets__option-info-name"><?php _e( 'My Account Page Widgets', 'jet-woo-builder' ); ?></div>
			<div class="avaliable-widgets__option-info-desc"><?php _e( 'These widgets will be available when editing the my account page template', 'jet-woo-builder' ); ?></div>
		</div>
		<div class="avaliable-widgets__controls">
			<div
				class="avaliable-widgets__control"
				v-for="(option, index) in pageOptions.myaccount_available_widgets.options"
			>
				<cx-vui-switcher
						:key="index"
						:name="`myaccount-avaliable-widget-${option.value}`"
						:label="option.label"
						:wrapper-css="[ 'equalwidth' ]"
						return-true="true"
						return-false="false"
						v-model="pageOptions.myaccount_available_widgets.value[option.value]"
				>
				</cx-vui-switcher>
			</div>
		</div>
	</div>
</div>
