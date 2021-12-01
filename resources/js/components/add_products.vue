<template>
    <div class="row justify-content-center">

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Add New</h4>
                        </div>
                        <div class="card-toolbar">
                            <button class="btn btn-primary" @click="create">Create</button>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="form-group row">
                                    <div v-if="$v.formData.name.$invalid">
                                        <p class="error" v-if="!$v.formData.name.required">Required</p>
                                    </div>
                                    <input type="text" placeholder="Product Name"
                                           v-model="formData.name" class="form-control form-control-lg">

                            </div>
                            <div class="form-group row">
                                <label>Short Description</label>
                                <textarea cols="30" rows="5"
                                          class="form-control form-control-lg" v-model="formData.short_desc"></textarea>
                            </div>
                            <div class="form-group row">
                                <label>Long Description</label>
                                <textarea cols="30" rows="5"
                                          class="form-control form-control-lg" v-model="formData.long_desc"></textarea>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <div v-if="$v.formData.p_quantity.$invalid">
                                        <p class="error" v-if="!$v.formData.p_quantity.integer">Required integer</p>
                                    </div>
                                    <input type="text" v-model="formData.p_quantity"
                                           placeholder="Quantity (optional)" class="form-control form-control-lg">
                                </div>
                                <div class="col-sm-6">
                                    <div v-if="$v.formData.p_price.$invalid">
                                        <p class="error" v-if="!$v.formData.p_price.decimal">Required decimal</p>
                                    </div>
                                    <input type="text" v-model="formData.p_price"
                                           placeholder="Price (optional)" class="form-control form-control-lg">
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Brand</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="$v.formData.brand.$invalid">
                            <p class="error" v-if="!$v.formData.brand.required">Required</p>
                        </div>
                        <select class="form-control form-control-lg" v-model="formData.brand">
                            <option value="" selected> Select Brand</option>
                            <option v-for="b in brands" :value="b.id" :key="b.id">{{ b.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Category</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="$v.formData.category.$invalid">
                            <p class="error" v-if="!$v.formData.category.required">Required</p>
                        </div>
                        <select class="form-control form-control-lg" v-model="formData.category" >
                            <option value="" selected> Select Category</option>
                            <option v-for="c in categories" :value="c.id" :key="c.id">{{ c.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Stock</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="$v.formData.p_in_stock.$invalid">
                            <p class="error" v-if="!$v.formData.p_in_stock.required">Required</p>
                        </div>
                        <select class="form-control form-control-lg" v-model="formData.p_in_stock" >
                            <option value="" selected> Select Stock</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="car-title">
                            <h4>Add Attributes</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control form-control-lg" @change="attributesChanged()" v-model="formData.attributes">
                                    <option v-for="a in attributes" :value="a">{{ a.name }}</option>
                                </select>
                            </div>
                            <div class="col-md-6" v-show="optionsMode">
                                <select class="form-control form-control-lg" v-model="formData.options" @change="optionsChanged()">
                                    <option v-for="o in formData.attributes._options" :value="o">{{ o.name }}</option>
                                </select>
                            </div>
                            <div class="col-md-12" v-show="detailsMode">
                                <ValidationObserver v-slot="{handleSubmit}">
                                    <form @submit.prevent="handleSubmit(add_attribute)">
                                        <div class="form-group row">
                                            <h6 class="col-md-12 col-form-label col-form-label-md">{{ formData.options.name }}</h6>
                                            <div class="col-md-3">
                                                <ValidationProvider name="Quantity" rules="required|integer" v-slot="{ errors }">
                                                    <input type="text" placeholder="Quantity"
                                                           class="form-control form-control-md" v-model="a_quantity">
                                                    <span style="color: red">{{ errors[0] }}</span><br>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-md-3">
                                                <ValidationProvider name="Price" :rules="{required: true, regex: /^\d*\.?\d*$/}" v-slot="{ errors }">
                                                    <input type="text" placeholder="Price"
                                                           class="form-control form-control-md" v-model="a_price">
                                                    <span style="color: red">{{ errors[0] }}</span><br>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-md-3">
                                                <ValidationProvider name="Stock" rules="required" v-slot="{ errors }">
                                                    <select v-model="a_in_stock" class="form-control form-control-md">
                                                        <option value="1" selected>Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                    <span style="color: red">{{ errors[0] }}</span><br>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </ValidationObserver>
                            </div>

                            <div class="col-md-12" v-show="formData.all_attributes.length > 0" style="margin-top: 10px;">
                                <div class="table-responsive">
                                    <table border="1" class="display">
                                        <thead>
                                        <td>Attribute</td>
                                        <td>Option</td>
                                        <td>Quantity</td>
                                        <td>Price</td>
                                        <td>In Stock</td>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(al, index) in formData.all_attributes">
                                                <td>
                                                    <button class="btn btn-danger" @click="delete_att(index)">X</button>
                                                    {{ al.at_name }}
                                                </td>
                                                <td>{{ al.op_name }}</td>
                                                <td>{{ al.quantity }}</td>
                                                <td>{{ al.price }}</td>
                                                <td>{{ al.in_stock == 1 ? 'Yes' : 'No' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Product Images</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row" v-show="formData.img.length > 0">
                            <div class="col-sm-2" v-for="(img, index) in formData.img">
                                <img :src="img" style="height: 80px;width: 80px">
                                <button class="btn btn-danger" @click="delete_img(index)">X</button>
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" @change="displayImages"
                                       multiple name="product_images[]" accept="image/*">
                                <label class="custom-file-label">Choose images</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate"
import { required, integer, decimal } from "vuelidate/lib/validators"
import '../../../public/js/my-js.js'
    export default {
        mixins: [validationMixin],
        name: "add_products.vue",
        data: () => {
            return {
                brands:{},
                categories:{},
                attributes:{},
                optionsMode:false,
                detailsMode:false,
                a_quantity:'',
                a_price:'',
                a_in_stock:'',
                a_id:'',
                formData:{
                    name:'',
                    short_desc:'',
                    long_desc:'',
                    p_quantity:'',
                    p_price:'',
                    brand:'',
                    category:'',
                    p_in_stock:'',
                    img:[],
                    has_attributes:0,
                    attributes:{},
                    options:{},
                    all_attributes:[],
                },
            }
        },

        validations: {
            formData:{
                name:{ required },
                brand:{ required },
                category:{ required },
                p_quantity:{ integer },
                p_price:{ decimal },
                p_in_stock:{ required },
            },
        },

        methods:{

            delete_att(index){
                this.formData.all_attributes.splice(index, 1);
            },

            delete_img(index){
                this.formData.img.splice(index, 1);
            },

            validateState(formData) {
                const { $dirty, $error } = formData
                return $dirty ? !$error : null
            },

            create(){
                this.$v.formData.$touch()
                if (this.$v.formData.$anyError){
                    toast_error('all feilds are required')
                    return;
                }

                this.formData.has_attributes = this.formData.all_attributes.length > 0 ? 1 : 0

                axios({
                    method: 'post',
                    url: main_url+'admin/products',
                    data: this.formData,
                }).then( (response) => {
                    if(response.data.status == true){
                        toast_success(response.data.message)
                        setTimeout( () => { window.location = response.data.redirect }, 3000)
                    }
                    else{
                        toast_error(response.data.message)
                    }
                });

            },

            add_attribute(){

                this.formData.all_attributes.push({
                    at_id:this.formData.attributes.id,
                    at_name:this.formData.attributes.name,
                    op_id:this.formData.options.id,
                    op_name:this.formData.options.name,
                    quantity:this.a_quantity,
                    price:this.a_price,
                    in_stock:this.a_in_stock
                });
                this.formData.attributes = {}
                this.formData.options = {}
                this.a_quantity = ''
                this.a_price = ''
                this.a_in_stock = ''
                this.detailsMode = false;
                this.optionsMode = false;
                this.getAttributes()
            },

            optionsChanged(){
                this.detailsMode = true;
            },

            attributesChanged(){
               this.optionsMode = true;
            },

            getBrands(){
                axios
                    .get(main_url+'admin/getBrands')
                    .then(response => (
                        this.brands = response.data
                    ));
            },

            getCategories(){
                axios
                    .get(main_url+'admin/getCategories')
                    .then(response => (
                        this.categories = response.data
                    ));
            },

            getAttributes(){
                axios
                    .get(main_url+'admin/getAttributes')
                    .then(response => (
                        this.attributes = response.data
                    ));
            },

            displayImages(e){
                for ( var i = 0; i < e.target.files.length; i++ ){
                    let file = e.target.files[i];
                    let reader = new FileReader();
                    let limit = 1024 * 1024 * 2;

                    if(file['size'] > limit){
                        toast_error('file size is more than 2MB')
                        return;
                    }

                    reader.onloadend = (f) => {
                        this.formData.img.push( reader.result )
                    }
                    reader.readAsDataURL(file)

                }
            },
        },

        mounted() {
            this.getBrands()
            this.getCategories()
            this.getAttributes()
            console.log('working')
        }
    }
</script>

<style scoped>
    td {
        padding: 10px;
        color: black;
    }
    thead td{
        font-weight: 700;
    }
    p.error{
        color: red;
        padding-left: 15px;
    }
</style>
