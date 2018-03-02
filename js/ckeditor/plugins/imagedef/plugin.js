CKEDITOR.plugins.add(
    "imagedef",
      {
          requires:["dialog"], //当按钮触发时弹出对话框
        init:function (a)
          {
            a.addCommand("imagedef", new CKEDITOR.dialogCommand("imagedef"));
              a.ui.addButton(
                "imagedef",
                {
                    label:"图片",
                    command:"imagedef",
                    icon:this.path + "imagedef.png"
                });
            CKEDITOR.dialog.add("imagedef", this.path + "dialogs/imagedef.js");
        }
    }
);