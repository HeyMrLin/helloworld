<template>
  <div>
    <el-row :gutter="24">
      <el-form label-position="right" label-width="90px" :inline="true">
        <el-col :span="8">
          <el-form-item :label="img">
            <el-input v-model="imgFileName"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="rename('img')">替换</el-button>
          </el-form-item>
        </el-col>
      </el-form>
    </el-row>
    <el-row :gutter="24">
      <el-form label-position="right" label-width="90px" :inline="true">
        <el-col :span="8">
          <el-form-item :label="config">
            <el-input v-model="configFileName"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="rename('config')">替换</el-button>
          </el-form-item>
        </el-col>
      </el-form>
    </el-row>
  </div>

</template>

<script>
  export default {
    name: "rename",
    data() {
      return {
        imgFileName:"",
        configFileName:"",
      }
    },
    props:["img","config"],
    methods:{
      rename(type){
        let _this=this;
        let name="";
        if(type==="img"){
          name = _this.imgFileName;
        }else {
          name = _this.configFileName;
        }
        $.post("http://localhost:8888/uploadfile/rename.php", {type:type,newname:name}, function (res) {
          console.log(JSON.parse(res));
          let json = JSON.parse(res);
          if(json.result === "200"){
            _this.imgFileName = "";
            _this.configFileName = "";
            _this.$message({
              message:"替换成功!",
              type:"success"
            });
            _this.$emit("get-data");
          }else {
            _this.message({
              message:"替换失败!请联系管理员!"
            })
          }
        });
      },
    },
  }
</script>

<style scoped>

</style>
