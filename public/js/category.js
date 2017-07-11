new Vue({
  el: '#app',
  data: {
    categories: [],
    category: {
      name: '',
      is_enabled: '1',
      parent: '1'
    },
    checkCategory: {
      id: '',
      name: '',
      is_enabled: '',
      parent: ''
    },
  },
  methods: {
    // получить все категории
    getCategories() {
      this.$http.get('/category').then(response => {
        if (response.body.status == 1) {
            this.categories = response.body.result;
        } else {
            alert(response.body.result);
        }
      }, response => {

      });
    },
    // показать продукты категории
    showCategory(id) {
      this.$http.get('/category/show?id='+id)
      .then(response => {
          if (response.body.status == 1) {
              msg = 'Список продуктов: \n';
              response.body.products.forEach(value => msg += value.name + '\n');
              alert(msg);
          } else {
              alert(response.body.result);
              this.getCategories();
          }
      }, response => {

      });
    },
    // добавить новую категорию
    addCategory () {
      if (this.category.name!='' && this.category.is_enabled!='' && this.category.parent!='') {
        this.$http.post('/category', {name: this.category.name, is_enabled: this.category.is_enabled, parent: this.category.parent})
        .then(response => {
            if (response.body.status == 1) {
                this.getCategories();
            } else {
                alert(response.body.result);
                this.getCategories();
            }
        }, response => {

        });
      } else {
        alert('Заполните все поля');
      }
    },
    // редактировать выбранную категорию
    editCategory(category) {
      this.checkCategory.id = category.id;
      this.checkCategory.name = category.name;
      this.checkCategory.is_enabled = category.is_enabled;
      this.checkCategory.parent = category.parent;
    },
    // сохранить редактируемую категорию
    saveCategory () {
      if (this.checkCategory.id!='' && this.checkCategory.name!='' && this.checkCategory.is_enabled!='' && this.checkCategory.parent!='') {
        this.$http.put("/category", {id: this.checkCategory.id, name: this.checkCategory.name, is_enabled: this.checkCategory.is_enabled, parent: this.checkCategory.parent})
        .then(response => {
            if (response.body.status == 1) {
                this.checkCategory.id = '';
                this.checkCategory.name = '';
                this.checkCategory.is_enabled = '';
                this.checkCategory.parent = '';
                this.getCategories();
            } else {
                alert(response.body.result);
                this.getCategories();
            }
        }, response => {

        });
      } else {
        alert('Заполните все поля');
      }
    },
    // удалить категорию
    deleteCategory(id) {
      this.$http.delete("/category?id="+id)
      .then(response => {
          if (response.body.status == 1) {
              this.checkCategory.id = '';
              this.checkCategory.name = '';
              this.checkCategory.is_enabled = '';
              this.checkCategory.parent = '';
              this.getCategories();
          } else {
              alert(response.body.result);
              this.getCategories();
          }
      }, response => {

      });
    },
  },
  created: function () {
    this.getCategories();
  },
});
