new Vue({
  el: '#app',
  data: {
    categories: [],
    products: [],
    product: {
      name: '',
      announce: '',
      is_enabled: '',
      description: '',
      categories: []
    },
    checkProduct: {
      id: '',
      name: '',
      announce: '',
      is_enabled: '',
      description: '',
      categories: []
    },
  },
  methods: {
    // получить все категории
    getCategories() {
      this.$http.get('/category').then(response => {
        this.categories = response.body;
      }, response => {

      });
    },
    // получить все продукты
    getProducts() {
      this.$http.get('/product').then(response => {
        this.products = response.body;
      }, response => {

      });
    },
    // добавить новую категорию
    addProduct () {
      if (this.product.name!='' && this.product.is_enabled!='') {
        this.$http.post('/product', {name: this.product.name, is_enabled: this.product.is_enabled, announce: this.product.announce, description: this.product.description, categories: this.product.categories})
        .then(response => {
          this.getProducts();
        }, response => {

        });
      } else {
        alert('Заполните все поля');
      }
    },
    // редактировать выбранную категорию
    editProduct(product) {
      this.checkProduct.id = product.id;
      this.checkProduct.name = product.name;
      this.checkProduct.is_enabled = product.is_enabled;
      this.checkProduct.announce = product.announce;
      this.checkProduct.description = product.description;
      this.checkProduct.categories = [];

      product.categories.forEach(value => {
        this.checkProduct.categories.push(value);
      });
    },
    // сохранить редактируемую категорию
    saveProduct () {
      if (this.checkProduct.id!='' && this.checkProduct.name!='' && this.checkProduct.is_enabled!='') {
        this.$http.put("/product", {id: this.checkProduct.id, name: this.checkProduct.name, is_enabled: this.checkProduct.is_enabled, announce: this.checkProduct.announce, description: this.checkProduct.description})
        .then(response => {

          // ставим новые категории
          categories: this.checkProduct.categories
          this.$http.put("/product/categories", {id: this.checkProduct.id, categories: this.checkProduct.categories})
          .then(response => {
            this.checkProduct.id = '';
            this.checkProduct.name = '';
            this.checkProduct.is_enabled = '';
            this.checkProduct.announce = '';
            this.checkProduct.description = '';
            this.checkProduct.categories = [];
            this.getProducts();
          }, response => {

          });

        }, response => {

        });
      } else {
        alert('Заполните все поля');
      }
    },
    // удалить категорию
    deleteProduct(id) {
      this.$http.delete("/product?id="+id)
      .then(response => {
        this.checkProduct.id = '';
        this.checkProduct.name = '';
        this.checkProduct.is_enabled = '';
        this.checkProduct.announce = '';
        this.checkProduct.description = '';
        this.checkProduct.categories = [];
        this.getProducts();
      }, response => {

      });
    },
  },
  created: function () {
    this.getProducts();
    this.getCategories();
  },
});