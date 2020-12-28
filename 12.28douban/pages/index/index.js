//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    movie:[]
  },
  onLoad(){
    // 页面加载时获取电影列表信息
    let that = this;
      wx.request({
        url: 'http://movie.1808a.com/douban/Movie/index/index',
        success(e){
            that.setData({
              movie:e.data.data
            })
        }
      })
  }
})
