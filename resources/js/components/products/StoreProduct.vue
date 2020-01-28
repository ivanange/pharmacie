<template>
  <div
    class="main-container d-flex justify-content-center align-items-center flex-column custom-scroll"
  >
    <b-form @submit.prevent="save" v-if="show" action="/products" method="post">
      <h2 class="mb-3">Product</h2>
      <b-form-input
        id="name"
        v-model="product.name"
        type="text"
        placeholder="Product name"
        class="my-2"
        style="width: 400px; height: 40px;"
      ></b-form-input>
      <div class="d-flex">
        <b-form-group label="Price">
          <b-form-input
            id="price"
            v-model="product.price"
            type="number"
            :placeholder="'Price in '+currency"
            class="my-2 mr-2"
            style=" height: 40px;"
            :state="product.price > 0"
          ></b-form-input>
        </b-form-group>
        <b-form-group label="Weight">
          <b-form-input
            id="weight"
            v-model="product.weight"
            type="number"
            placeholder="Weight"
            class="my-2 mx-2"
            style=" height: 40px;"
            :state="product.weight > 0"
          ></b-form-input>
        </b-form-group>
        <b-form-group label="Quantity">
          <b-form-input
            id="qte"
            v-model="product.qte"
            type="number"
            step="1"
            placeholder="Quantity"
            class="my-2 mx-2"
            style=" height: 40px;"
          ></b-form-input>
        </b-form-group>
      </div>
      <b-form-group label="Expire dater">
        <datetime
          id="expireDate"
          type="datetime"
          v-model="product.expireDate"
          title="Expirey date"
          placeholder="Expirey date"
          input-class="border rounded my-3  pl-2"
          input-style="width: 200px; height: 40px;"
        ></datetime>
      </b-form-group>
      <b-form-group label="Manufacturer">
        <v-select
          v-model="product.manufacturer"
          :options="manufacturers"
          placeholder="Manufacturer"
          class="custom"
          style="min-width: 300px;"
        ></v-select>
        <b-form-file v-model="product.image" accept="image/*" class="mt-3"></b-form-file>
      </b-form-group>
      <div class="d-flex justify-content-end mt-4 mb-5">
        <b-button type="submit" class="mr-2" variant="info" style="min-width:70px;">Save</b-button>
      </div>
    </b-form>
  </div>
</template>

<script>
import { DateTime } from "luxon";

export default {
  name: "StoreProduct",
  props: {
    id: {
      type: Number | String,
      default: null
    },
    propProduct: {
      type: Object,
      default: function() {
        return {
          id: null,
          name: "",
          price: null,
          weight: null,
          qte: null,
          expireDate: undefined,
          manufacturer: "",
          image: null
        };
      }
    }
  },
  data: function() {
    return {
      product: this.propProduct,
      show: true,
      edit: false,
      setup: false
    };
  },
  methods: {
    save() {
      let data = this.serialize();
      this[this.action](data);
      this.$emit("saved");
    },
    serialize() {
      console.log(this.product.image);
      let data = {
        ...this.product,
        image: this.product.image
          ? new FileReader().readAsDataURL(this.product.image[0])
          : null
      };
      return data;
    },
    setupDates() {
      if (this.edit) {
        this.product.expireDate = this.product.expireDate
          ? this.setupDate(this.product.expireDate).toISO()
          : "";
      }
    },
    setupProduct() {
      if (!this.setup) {
        let product = this.getProduct(this.id);
        if (product) {
          this.product = product || this.product;
          this.setupDates();
          this.setup = true;
        }
        return product;
      }
    }
  },

  created: function() {
    if (this.id || this.propProduct.id) {
      this.edit = true;
      this.$store.watch(
        (state, getters) => state.loaded,
        () => {
          if (this.loaded && !this.propProduct.id) {
            if (this.setupProduct()) {
            } else {
              this.$router.push("/products");
            }
          }
        },
        { immediate: true, deep: true }
      );
      this.setupProduct();
    }
    this.action = (this.edit ? "update" : "create") + "Product";
  }
};
</script>

<style lang="scss" scoped>
</style>
