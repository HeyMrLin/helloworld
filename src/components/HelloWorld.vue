<template>
  <div>
    <el-upload
      class="upload-single"
      ref="uploadSingle"
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
    <re-name :img="imgFileName" :config="configFileName" @get-data="getData"></re-name>
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
      <el-table-column
        label="operation"
        width="360"
        align="center"
      >
        <template slot-scope="scope">
          <el-button type="text" @click="showPicture(scope.row)" size="small">查看</el-button>
          <el-upload
            class="upload"
            ref="upload"
            action="/dist/static/php/upload_file.php"
            :on-success="successUpload">
            <el-button slot="trigger" size="small" type="text">替换</el-button>
            <!--<el-button style="margin-left: 10px;" size="small" type="text" @click="submitUpload">上传到服务器</el-button>-->
          </el-upload>
          <el-button type="text" @click="deleteFiles(scope.row)" size="small" style="margin-left: 10px">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog
      :visible.sync="isShow"
      custom-class="showPictureDialog"
      width="60%"
    >
      <template>
        <el-carousel type="" height="450px">
          <el-carousel-item v-for="(picture,index) in pictureArr" :key="index">
            <div class="showPictureWrap">
              <img :src="picture" class="showPictureImg">
            </div>
          </el-carousel-item>
        </el-carousel>
      </template>
    </el-dialog>

    <!--是否删除-->
    <el-dialog
      title="提示"
      :visible.sync="isDelete"
      width="30%">
      <span>是否删除!</span>
      <span slot="footer" class="dialog-footer">
    <el-button @click="isDelete = false">取 消</el-button>
    <el-button type="primary" @click="deleteFile">确 定</el-button>
  </span>
    </el-dialog>
  </div>
</template>

<script>
  import reName from './rename.vue'

  export default {
    name: 'HelloWorld',
    data() {
      return {
        imgFileNameData: [], //文件名
        deleteFileName: "", //需要删除的图片名
        imgFileName: "img_1.0.0",
        configFileName: "config_1.0.0",
        isShow: false,
        serverPath: "",
        pictureArr: [],
        isDelete: false,
        imgHeight: "",
        imgWidth: "",
      }
    },
    mounted() {
      this.getData();
    },
    methods: {
      submitUpload() {
        this.$refs.uploadSingle.submit();
      },
      successUpload(response) {
        if (response.result === "200") {
          this.getData();
          this.$message({
            message: "上传成功!",
            type: "success"
          });
        }
      },
      getData() {
        let _this = this;
        _this.imgFileNameData = [];
        $.post("/dist/static/php/handlefile.php", {}, function (res) {
          console.log(JSON.parse(res));
          let json = JSON.parse(res);
          _this.serverPath = json.imgPath;
          for (let i = 0; i < json.data.length; i++) {
            _this.imgFileNameData.push(JSON.parse(json.data[i]))
          }
          _this.imgFileNameData.sort(function (a, b) {
            return a.filename.localeCompare(b.filename);
          })
          _this.imgFileName = json.imgFileName;
          _this.configFileName = json.configFileName.replace(/\.js/, "");
        });
      },
      deleteFile() {
        let _this = this;
        $.post("/dist/static/php/deletefile.php", {filename: this.deleteFileName}, function (data) {
          console.log(JSON.parse(data));
          let json = JSON.parse(data);
          if (json.result === "200") {
            _this.isDelete = false;
            _this.getData();
            _this.deleteFileName = "";
            _this.$message({
              message: "删除成功!",
              type: "success"
            });
          }
        })
      },
      deleteFiles(row) {
        this.deleteFileName = row.filename;
        this.isDelete = true;
      },
      showPicture(row) {
        this.isShow = true;
        this.pictureArr.length = 0;
        this.pictureArr.push("http://" + this.serverPath + "/" + row.filename);
        let img = new Image();
        img.src = "http://" + this.serverPath + "/" + row.filename;
        if (img.complete) {
          this.imgHeight = img.height;
          this.imgWidth = (img.width) * ((img.height) / 450);
        }
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

  .upload {
    display: inline-block;
    margin-left: 10px;
  }

  .upload .el-upload-list {
    display: inline-block;
  }

  .el-upload-list {
    display: inline-block;
  }

  .upload-single {
    height: 100px;
  }

  .showPictureDialog .el-dialog__header {
    height: 0;
  }
  .showPictureDialog .el-dialog__body {
    padding: 0;
  }

  .showPictureDialog .showPictureWrap {
    width: 100%;
    height: 100%;
    margin: 0 auto;
    text-align: center;
    vertical-align: middle;
  }

  .showPictureDialog .showPictureImg {
    height: 100%;
    vertical-align: middle;
  }
  .showPictureDialog .el-carousel__item {
    display: block!important;
  }

</style>
