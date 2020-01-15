<template>
  <div>
    
<div class="articles">
            <Article
          v-for="article in Object.values(this.command.articles)"
          :article="article"
          :key="article.product.id"
          :deleteButton="false"
        />
</div>
     
  </div>
</template>

<script>
import Article from "./Article";
import { DateTime } from "luxon";

export default {
  name: "StoreCommand",
  components: {
    Article
  },
  props: {
    id: {
      type: Number | String,
      default: null
    },
    propCommand: {
      type: Object,
      default: function() {
        return {
          id: null,
          name: "",
          issueDate: DateTime.utc().toISO(),
          deliveryDate: null,
          status: 1,
          articles: {}
        };
      }
    }
  },
  data: function() {
    return {
      article: { product: {}, qte: null },
      products: {},
      command: this.propCommand,
      show: true,
      edit: false
    };
  },
  computed: {
    issueDateF: {
      get: function() {
        return this.command.issueDate;
      },
      set: function(val) {
        return;
      }
    },
    productlist: {
      get: function() {
        return Object.values(this.products).map(el => ({
          value: el,
          label: `${el.name} : ${el.price}`
        }));
      },
      set: function(val) {
        return;
      }
    },
    qte: {
      get: function() {
        return this.article.qte;
      },
      set: function(val) {
        if (this.hasActiveProduct()) {
          return (this.article.qte = this.max >= val ? val : this.max);
        }
      }
    },
    max: function() {
      return this.hasActiveProduct()
        ? this.products[this.article.product.id].qte
        : 0;
    },
    statuses: function() {
      return Object.keys(this.STATUS).map(el => ({
        text: (el[0] + el.substr(1).toLowerCase()).replace(/er$/, "é"),
        value: this.STATUS[el]
      }));
    }
  },
  methods: {
    add() {
      if (this.article.product && this.article.qte) {
        this.command.articles[this.article.product.id] = {
          product: this.article.product,
          qte: this.article.qte
        };
        this.article = { product: {}, qte: null };
      }
    },
    hasActiveProduct() {
      return Object.keys(this.article.product).length;
    },
    remove(id) {
      delete this.command.articles[id];
      this.$forceUpdate();
    },
    save() {
      if (this.validate()) {
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
        (this.command.deliveryDate
          ? DateTime.fromISO(this.command.deliveryDate) >=
            DateTime.fromISO(this.command.issueDate)
          : true)
      );
    },
    serialize() {
      return {
        ...this.command,
        articles: Object.keys(this.command.articles).reduce((acc, key) => {
          acc[key] = { qte: this.command.articles[key].qte };
          return acc;
        }, {})
      };
    },
    setupDates() {
      if (this.edit) {
        this.command.issueDate = DateTime.fromFormat(
          this.command.issueDate,
          "yyyy-MM-dd HH:mm:ss",
          { zone: "UTC" }
        ).toISO();

        this.command.deliveryDate = this.command.deliveryDate
          ? DateTime.fromFormat(
              this.command.deliveryDate,
              "yyyy-MM-dd HH:mm:ss",
              { zone: "UTC" }
            ).toISO()
          : null;
      }
    },
    init() {
      if (this.id) {
        this.edit = true;
        this.$http
          .get(`/api/commands/${this.id}`)
          .then(data => {
            this.command = data.body;
            this.setupDates();
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
  },
  created: function() {
    this.init();
  }
};
</script>

<style lang="scss" >
.custom .vs__dropdown-toggle {
  height: 100%;
  border-radius: 0px;
}
</style>
