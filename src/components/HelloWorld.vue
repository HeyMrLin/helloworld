<template>
  <div>
    <el-upload
      class="upload-demo"
      ref="upload"
      action="/dist/static/php/upload_file.php"
      :on-success="successUpload"
      :auto-upload="false">
      <el-button slot="trigger" size="small" type="primary">选取文件</el-button>
      <el-button style="margin-left: 10px;" size="small" type="success" @click="submitUpload">上传到服务器</el-button>
      <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
    </el-upload>
    <el-row :gutter="24">
      <el-form label-position="right" label-width="90px" :inline="true">
        <el-col :span="8">
          <el-form-item label="文件名">
            <el-input v-model="deleteFileName"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="deleteFile()">删除</el-button>
          </el-form-item>
        </el-col>
      </el-form>
    </el-row>
    <re-name :img="imgFileName" :config="configFileName"></re-name>
    <el-table
      :data="imgFileNameData"
      style="width: 100%">
      <el-table-column
        type="index"
        label="index"
        width="80">
      </el-table-column>
      <el-table-column
        prop="filename"
        align="center"
        label="file"
        width="180">
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import reName from './rename.vue'
  export default {
    name: 'HelloWorld',
    data() {
      return {
        msg: 'Welcome to Your Vue.js App',
        imgFileNameData: [], //文件名
        deleteFileName:"", //需要删除的图片名
        imgFileName:"",
        configFileName:"",
      }
    },
    mounted() {
      this.getData();
    },
    methods: {
      submitUpload() {
        this.$refs.upload.submit();
      },
      successUpload(response){
        if(response.result === "200"){
          this.getData();
        }
      },
      getData() {
        let _this = this;
        _this.imgFileNameData=[];
        $.post("/dist/static/php/handlefile.php", {}, function (res) {
          //console.log(JSON.parse(res));
          let json = JSON.parse(res);
          for (let i = 0; i < json.data.length; i++) {
            _this.imgFileNameData.push(JSON.parse(json.data[i]))
          }
          _this.imgFileNameData.sort(function (a,b) {
            return a.filename-b.filename;
          });
          _this.imgFileName = json.imgFileName;
          _this.configFileName = json.configFileName.replace(/\.js/,"");
        });
      },
      deleteFile() {
        let _this=this;
        $.post("/dist/static/php/deletefile.php", {filename: this.deleteFileName}, function (data) {
          //console.log(JSON.parse(data));
          let json = JSON.parse(data);
          if (json.result === "200") {
            _this.getData();
            _this.deleteFileName="";
            _this.$message({
              message:"删除成功!",
              type:"success"
            });
          }
        })
      },
    },
    components: {
      reName
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  h1, h2 {
    font-weight: normal;
  }

  ul {
    list-style-type: none;
    padding: 0;
  }

  li {
    display: inline-block;
    margin: 0 10px;
  }

  a {
    color: #42b983;
  }
</style>
