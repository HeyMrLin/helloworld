<template>
  <div>
    <el-upload
  class="upload-demo"
  ref="upload"
  action="http://localhost:1234/updatefile/upload_file.php"
  :on-preview="handlePreview"
  :on-remove="handleRemove"
  :auto-upload="false">
  <el-button slot="trigger" size="small" type="primary">选取文件</el-button>
  <el-button style="margin-left: 10px;" size="small" type="success" @click="submitUpload">上传到服务器</el-button>
  <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
</el-upload>
<el-table
      :data="imgFileNameData"
      style="width: 100%">
      <el-table-column
        prop="rownum"
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
export default {
  name: 'HelloWorld',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      imgFileNameData:[],
    }
  },
  mounted(){
    this.getData();
  },
  methods: {
      submitUpload() {
        this.$refs.upload.submit();
      },
      handleRemove(file, fileList) {
        console.log(file, fileList);
      },
      handlePreview(file) {
        console.log(file);
      },
      getData(){
        let _this = this;
        $.post("http://localhost:1234/updatefile/handlefile.php",{},function(res){
          //console.log(JSON.parse(res));
          let json = JSON.parse(res);
          for (let i=0;i<json.data.length;i++){
            _this.imgFileNameData.push(JSON.parse(json.data[i]))
          }
        });
      }
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
