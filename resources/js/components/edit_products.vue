<template>
    <div class="row justify-content-center">

        <div class="col-lg-1"></div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Update</h4>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex">
                            <select class="form-control mr-2" v-model="varition_section">
                                <option value="1">Simple Product</option>
                                <option value="2">Variable Product</option>
                            </select>
                            <button class="btn btn-primary" @click="update">Update</button>
                        </div>
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
                        <textarea cols="30" rows="5" placeholder="Short Description"
                                  class="form-control form-control-lg" v-model="formData.short_desc"></textarea>
                    </div>
                    <div class="form-group row">
                        <textarea cols="30" rows="5" placeholder="Long Description"
                                  class="form-control form-control-lg" v-model="formData.long_desc"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div v-if="$v.formData.p_quantity.$invalid">
                                <p class="error" v-if="!$v.formData.p_quantity.integer">Required integer</p>
                            </div>
                            <input type="text" v-model="formData.p_quantity"
                                   placeholder="Quantity (optional)" class="form-control form-control-lg">
                        </div>
                        <div class="col-sm-4">
                            <div v-if="$v.formData.p_price.$invalid">
                                <p class="error" v-if="!$v.formData.p_price.decimal">Required decimal</p>
                                <p class="error" v-if="!$v.formData.p_price.required">Required</p>
                            </div>
                            <input type="text" v-model="formData.p_price"
                                   placeholder="Price" class="form-control form-control-lg">
                        </div>
                        <div class="col-sm-4">
                            <div v-if="$v.formData.p_sale_price.$invalid">
                                <p class="error" v-if="!$v.formData.p_sale_price.decimal">Required decimal</p>
                            </div>
                            <input type="text" v-model="formData.p_sale_price"
                                   placeholder="Sale Price (optional)" class="form-control form-control-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
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

        <div class="col-lg-1"></div>

        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Product Images</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row" v-show="formData.old_images.length > 0">
                        <div class="col-sm-2" v-for="(img, index) in formData.old_images">
                            <img :src="img.file" style="height: 80px;width: 80px">
                            <button class="btn btn-danger" @click="delete_img(index)">{{ img.status == true ? 'X' : '-' }}</button>
                        </div>
                    </div>
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

        <div class="col-lg-10" v-if="varition_section == 2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Add Variations</h4>
                    </div>
                    <div class="card-toolbar"></div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-3">
                            <p class="p-tag" @click="() => options_check = false">Add Variations</p>
                            <hr>
                            <p class="p-tag" @click="() => options_check = true">Make Options</p>
                        </div>
                        <div class="col-lg-9">
                            <div v-show="!options_check">
                                <div class="form-group row justify-content-center">
                                    <input type="text" placeholder="Attribute Name" class="form-control col-sm-3 m-1" v-model="varition_att">
                                    <input type="text" placeholder="Add options with | sign" class="form-control col-sm-6 m-1" v-model="varition_option">
                                    <input type="submit" value="Add" class="btn btn-primary col-sm-1 m-1" @click="add_variation">
                                </div>
                                <p class="error">If any variation is deleted all options will be build again or refresh the page.</p>
                                <div class="table-responsive justify-content-center" v-if="formData.varition.length > 0">
                                    <table border="1" class="display">
                                        <thead>
                                        <td></td>
                                        <td>Attribute</td>
                                        <td>Option</td>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(v, index) in formData.varition">
                                            <td>
                                                <button class="btn btn-danger" @click="delete_varitaion(index)">X</button>
                                            </td>
                                            <td>{{ v.att }}</td>
                                            <td>{{ v.option }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-show="options_check">
                                <div class="form-group row" v-if="formData.varition.length > 0">
                                    <div class="col-lg-3" v-for="(vr, index) in formData.varition">
                                        <label class="btn-label">{{ vr.att }}</label>
                                        <select class="form-control form-control-md" :id="vr.att">
                                            <option :value="null">Select Please</option>
                                            <option v-for="vr_options in vr.option" :value="vr_options">{{ vr_options }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <input type="text" placeholder="Quantity"
                                               class="form-control form-control-md" v-model="v_quantity">
                                        <div v-if="$v.v_quantity.$invalid">
                                            <p class="error" v-if="!$v.v_quantity.required">Required</p>
                                            <p class="error" v-if="!$v.v_quantity.integer">Required integer</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" placeholder="Price" class="form-control form-control-md" v-model="v_price">
                                        <div v-if="$v.v_price.$invalid">
                                            <p class="error" v-if="!$v.v_price.required">Required</p>
                                            <p class="error" v-if="!$v.v_price.decimal">Required decimal</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" placeholder="Sale Price" class="form-control form-control-md" v-model="v_sale_price">
                                        <div v-if="$v.v_sale_price.$invalid">
                                            <p class="error" v-if="!$v.v_sale_price.decimal">Required decimal</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="form-control form-control-md" v-model="v_in_stock">
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <div v-if="$v.v_in_stock.$invalid">
                                            <p class="error" v-if="!$v.v_in_stock.required">Required</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button class="btn btn-primary" @click="add_options">Add</button>
                                    </div>
                                </div>

                                <div class="table-responsive justify-content-center" v-if="formData.v_options.length > 0">
                                    <table border="1" class="display">
                                        <thead>
                                        <td></td>
                                        <td>Variations</td>
                                        <td>Quantity</td>
                                        <td>Price</td>
                                        <td>Sale Price</td>
                                        <td>In Stock</td>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(v, index) in formData.v_options">
                                            <td>
                                                <button class="btn btn-danger" @click="delete_options(index)">X</button>
                                            </td>
                                            <td>{{ v.options }}</td>
                                            <td>{{ v.quantity }}</td>
                                            <td>{{ v.price }}</td>
                                            <td>{{ v.sale_price }}</td>
                                            <td>{{ v.in_stock }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
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
        name: "edit_products.vue",
        props:{
            product:{ type: Object },
            Cbrands:{ type: Array },
            Ccategories:{ type: Array },
            images:{ type: Array, default: () => { notEmpty:'not empty' }, },
            att:{ type: Array , default: () => { notEmpty:'not empty' }, },
            options:{ type: Array , default: () => { notEmpty:'not empty' }, },
            variations:{ type: Array , default: () => { notEmpty:'not empty' }, },
            variation_values:{ type: Array , default: () => { notEmpty:'not empty' }, },
        },
        data: () => {
            return {
                varition_section:1,
                varition_att:'',
                varition_option:'',
                varition:[],
                options_check:false,
                v_quantity:'',
                v_price:'',
                v_sale_price:'',
                v_in_stock:1,
                v_att_op:[],

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
                    p_sale_price:'',
                    brand:'',
                    category:'',
                    p_in_stock:'',
                    img:[],
                    has_attributes:0,
                    varition:[],
                    v_options:[],
                    old_images:[],
                },
            }
        },

        validations: {
            v_quantity: {required,integer},
            v_price: {required, decimal},
            v_sale_price: { decimal},
            v_in_stock: {required},
            formData:{
                name:{ required },
                brand:{ required },
                category:{ required },
                p_quantity:{ integer },
                p_price:{ required, decimal },
                p_sale_price:{ decimal },
                p_in_stock:{ required },
            },
        },

        methods:{

            add_options(){

                this.$v.v_quantity.$touch()
                this.$v.v_price.$touch()
                this.$v.v_in_stock.$touch()

                if (this.$v.v_quantity.$anyError ||
                    this.$v.v_price.$anyError ||
                    this.$v.v_in_stock.$anyError){
                    toast_error('all feilds are required')
                    return;
                }

                let option_array = [];
                this.formData.varition.map( (e) => {
                    var select = $('#'+e.att).val();
                    option_array.push(select)
                })
                this.formData.v_options.push({
                    'options':option_array,
                    'quantity':this.v_quantity,
                    'price':this.v_price,
                    'sale_price':this.v_sale_price,
                    'in_stock':this.v_in_stock
                });
            },

            delete_options(index){
                this.formData.v_options.splice(index, 1);
            },

            delete_varitaion(index){
               this.formData.v_options = []
                this.formData.varition.splice(index, 1);
            },

            add_variation(){

                let chk = true;

                if ( this.varition_att == '' || this.varition_option == '' ){
                    chk = false;
                }

                if ( this.formData.varition.length > 0 ){
                    this.varition.filter( (e) => {
                        if (e.att == this.varition_att){
                            chk = false;
                        }
                    })
                }

                if (chk == false){
                    alert('already added');
                    return;
                }

                this.varition_option = this.varition_option.split('|')
                this.formData.varition.push({
                    'att': this.varition_att,
                    'option': this.varition_option
                })
                this.varition_att = ''
                this.varition_option = ''
            },

            delete_att(index){
                this.formData.all_attributes.splice(index, 1);
            },

            delete_img(index){
                this.formData.old_images[index].status = false
                // this.formData.old_images.splice(index, 1);
            },

            validateState(formData) {
                const { $dirty, $error } = formData
                return $dirty ? !$error : null
            },

            update(){
                this.$v.formData.$touch()
                if (this.$v.formData.$anyError){
                    toast_error('all feilds are required')
                    return;
                }

                this.formData.has_attributes = this.formData.v_options.length > 0 ? 1 : 0

                axios({
                    method: 'PATCH',
                    url: main_url+'admin/products/'+this.product.id,
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

            optionsChanged(){
                this.detailsMode = true;
            },

            attributesChanged(){
                this.optionsMode = true;
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

            on_load(){

                this.categories = this.Ccategories
                this.brands = this.Cbrands

                this.formData.name = this.product.name
                this.formData.short_desc = this.product.short_description
                this.formData.long_desc = this.product.long_description
                this.formData.p_quantity = this.product.quantity
                this.formData.p_price = this.product.price
                this.formData.p_sale_price = this.product.sale_price
                this.formData.p_in_stock = this.product.in_stock
                this.formData.brand = this.product.brand_id
                this.formData.category = this.product.category_id

                this.varition_section = this.product.has_attributes == 1 ? 2 : 1

                if (this.images.length > 0){
                    for(var j = 0; j < this.images.length; j++) {
                        this.formData.old_images.push({
                            image_id:this.images[j].id,
                            file: main_url+'public/uploads/'+this.images[j].paths,
                            status:true
                        })
                    }
                }

                if (this.product.has_attributes == 1){
                    let op = []
                    this.att.map( (a) => {
                        this.options.map( (o) => {
                            if (a.id == o.attribute_id){
                                op.push(o.name)
                            }
                        })
                        this.formData.varition.push({
                            'att': a.name,
                            'option': op
                        })
                        op = []
                    })


                    let combos = null
                    this.variation_values.map( (vv) => {
                        this.variations.map( (v) => {
                            if ( vv.combo_id === v.id  ){
                                combos = v.option_name.split('|')
                                combos.shift()
                                console.log(combos)
                            }
                        })
                        this.formData.v_options.push({
                            'options':combos,
                            'quantity':vv.quantity,
                            'price':vv.price,
                            'sale_price':vv.sale_price,
                            'in_stock':vv.in_stock
                        });
                        combos = []
                    })
                }
            },
        },

        mounted() {
            this.on_load()
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
    .p-tag{
        color: black;
        cursor: pointer;
    }
    .p-tag:hover{
        color: #4425CB;
    }
</style>
