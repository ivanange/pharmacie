<template>
  <div>
    <b-form @submit.prevent="save" v-if="show" action="/commands" method="post">
      <b-form-input
        id="name"
        v-model="command.name"
        type="text"
        placeholder="Optional command name"
      ></b-form-input>

      <datetime
        id="issueDate"
        type="datetime"
        v-model="issueDateF"
        title="Issue date"
        placeholder="Issue date"
      ></datetime>
      <datetime
        id="deliveryDate"
        type="datetime"
        v-model="command.deliveryDate"
        title="Delivery date"
        placeholder="Delivery date"
      ></datetime>

      <b-form-group label="Status">
        <b-form-radio v-model="command.status" name="status" value="1">En cours</b-form-radio>
        <b-form-radio v-model="command.status" name="status" value="2">Délivré</b-form-radio>
        <b-form-radio v-model="command.status" name="status" value="3">Annulé</b-form-radio>
      </b-form-group>

      <b-form-group
        label="Articles"
        id="articles"
        v-if="Object.values(this.command.articles).length"
      >
        <Command
          v-for="article in Object.values(this.command.articles)"
          :article="article"
          :key="article.product.id"
          @remove="remove($event)"
        ></Command>
      </b-form-group>

      <b-form-group label="Add article">
        <b-input-group>
          <b-form-select
            v-model="article.product"
            :options="Object.values(this.products).map(el => ({
                value: el,
                text: `${el.name} : ${el.price}`
            }))"
          ></b-form-select>

          <b-input-group-append>
            <b-form-input id="quantity" v-model="article.qte" type="number" placeholder="Qte"></b-form-input>
            <b-button variant="primary" @click.stop="add">Add</b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form-group>

      <b-button type="submit" variant="primary">Save</b-button>
    </b-form>
  </div>
</template>

<script>
// transform articles array to object(map) after fetching command (oncreated)
//manage products representation accross app (take note of server)
import Article from "./Article";
import { DateTime } from "luxon";
export default {
  name: "StoreCommand",
  components: {
    Article
  },
  props: {
    id: {
      type: Number,
      default: null
    },
    edit: {
      type: Boolean,
      default: false
    },
    command: {
      type: Object,
      default: function() {
        return {
          id: null,
          name: "",
          issueDate: DateTime.utc().toISO(),
          //.toLocaleString(DateTime.DATETIME_MED),
          deliveryDate: null,
          //DateTime.local(),
          status: 1,
          articles: {}
        };
      }
    },
    products: {
      type: Object,
      default: function() {
        return {};
      }
    }
  },
  data: function() {
    return {
      article: { product: {}, qte: null },
      show: true
    };
  },
  computed: {
    issueDateF: {
      get: function() {
        return Datetime.local().toLocaleString(DateTime.DATETIME_MED);
      },
      set: function($n, $o) {
        return;
      }
    }
  },
  methods: {
    add() {
      if (this.article.product & this.article.qte) {
        this.command.articles[this.article.product.id] = {
          product: this.article.product,
          qte: this.article.qte
        };
        this.command.articles = { product: {}, qte: null };
      }
    },
    remove(id) {
      delete this.command.articles[id];
    },
    save() {
      if (!this.validate()) {
        let data = this.serialize();
        console.log(data);
        this.$http[this.method](this.url, data)
          .then(data => {
            console.log(data);
            //this.command = data.body;
          })
          .catch(e => console.log(e));
      }
    },
    validate() {
      return (
        Object.keys(this.command.articles).length &&
        this.command.issueDate &&
        DateTime.fromISO(this.command.deliveryDate) >=
          DateTime.fromISO(this.command.issueDate)
      );
    },
    serialize() {
      return {
        ...this.command,
        issueDate: this.command.issueDate.toISO(),
        articles: Object.keys(this.command.articles).map(key => {
          let article = {};
          article[key] = { qte: this.command.articles[key].qte };
          return article;
        })
      };
      /*
        issueDate: this.command.issueDate
          ? DateTime.fromISO(this.command.issueDate).toFormat(
              "y-LL-dd HH:mm:ss"
            )
          : null,

        deliveryDate: this.command.deliveryDate
          ? DateTime.fromISO(this.command.deliveryDate).toFormat(
              "y-LL-dd HH:mm:ss"
            )
          : null,
 */
    }
  },
  created: function() {
    if (this.id) {
      this.edit = true;
      this.$http
        .get(`/api/commands/${this.id}`)
        .then(data => {
          this.command = data.body;
          this.command.articles = this.command.articles.reduce((acc, val) => {
            acc[val.product.id] = val;
            return acc;
          }, {});
        })
        .catch(e => console.log(e));
    }
    this.$http
      .get("/api/products")
      .then(
        res =>
          (this.products = res.body.reduce((acc, val) => {
            acc[val.id] = val;
            return acc;
          }, {}))
      )
      .catch(e => console.log(e));
    this.url = this.edit ? `/api/commands/${this.id}` : `/api/commands`;
    this.method = this.edit ? "put" : "post";
  }
};
</script>

<style lang="scss" scoped>
</style>
