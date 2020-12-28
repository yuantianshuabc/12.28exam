// pages/edit/edit.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    data:"",
    content:"",
    mid:""
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    let mid = options.id;
    this.setData({
      mid
    })
    let that=this;
    // console.log(mid)
    // 发送网络请求，获得电影详情和评论数
    wx.request({
      url: 'http://movie.1808a.com/douban/Movie/read/id/'+mid,
      success(e){
        // console.log(e.data.data.content)
        // 异步更新数据源
        that.setData({
          data:e.data.data.data,
          content:e.data.data.content
        })
      }
    })
  },
  formSubmit(e){

    let mid=this.data.mid;
    console.log(mid)
    let content=e.detail.value.comment;
    let that=this;
    // 提交网络请求
    wx.request({
      url: 'http://movie.1808a.com/douban/Movie/save',
      data:{
        mid:mid,
        content:content
      },
      success(e){
        if(e.data.code == 200){
          // 添加成功后更新数据源
          that.setData({
            data:e.data.data.data,
            content:e.data.data.content
          })
        }else{
          wx.showModal({
            title:"文字最短5个",
            showCancel:false
          })
        }
      }
    })
  }
})