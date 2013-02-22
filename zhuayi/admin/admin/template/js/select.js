if(typeof HTMLElement!="undefined" && !HTMLElement.prototype.insertAdjacentElement)
{
	HTMLElement.prototype.insertAdjacentElement = function(where,parsedNode)
	{
		switch (where)
		{
			case 'beforeBegin':
				this.parentNode.insertBefore(parsedNode,this);
			break;
			case 'afterBegin':
				this.insertBefore(parsedNode,this.firstChild);
				//alert(this);
			break;
			case 'beforeEnd':
				this.appendChild(parsedNode);
			break;
			case 'afterEnd':
			if(this.nextSibling)
			{
				this.parentNode.insertBefore(parsedNode,this.nextSibling);
			}
			else
			{
				this.parentNode.appendChild(parsedNode);
			}
				break;
		}
	}
	
}

function sortMenu(_storeValueObjName, _showSelectObjName, _sortArr)
{
    this.storeValueObj=document.getElementById(_storeValueObjName);
    this.showSelectObj=document.getElementById(_showSelectObjName);
    this.sortArr=_sortArr;
    /**
     * 获取第一层分类，并显示在showSelectObj中
     * _sortMenuObj:sortMenu的实例对象，指向自己
     */
    this.initSorts=function(_sortMenuObj)
    {
        this.storeValueObj.value=0;
        _select=document.createElement("select");
        this.showSelectObj.insertAdjacentElement("afterBegin",_select);
        _select.sortMenuObj=_sortMenuObj;
        _select.onchange=function()
        {
            this.sortMenuObj.setSorts(this,this.sortMenuObj);
        }
		//_select
        //_select.add(new Option("1",""));
	   _select.options[0]  = new Option('==请选择==','');
	  	var j=1;
        for (var i = 0; i < this.sortArr.length; i++)
        {
			
            if (this.sortArr[i][2] == 0)
            {
               // _select.add(new Option(this.sortArr[i][1],this.sortArr[i][0]));
			    _select.options[j]  = new Option(this.sortArr[i][1],this.sortArr[i][0]);
				//alert(j);
				j++;
            }
			
        }
    }

    /**
     * 下拉框联动
     * _curSelect:当前选择的下拉框
     * _sortMenuObj:sortMenu的实例对象，指向自己
     */
    this.setSorts=function(_curSelect,_sortMenuObj)
    {
        //若当前下拉框后面还有下拉框，即有下级下拉框时，清除下级下拉框，在后面会重新生成下级部分
        //下级下拉框与当前下拉框由于都是显示在showSelectObj中，故它们是兄弟关系，所以用nextSibling获取
        while (_curSelect.nextSibling)
        {
            _curSelect.parentNode.removeChild(_curSelect.nextSibling);
        }

        //获取当前选项的值
        _iValue = _curSelect.options[_curSelect.selectedIndex].value;
        //如果选择的是下拉框第一项(第一项的值为"")
        if (_iValue == "")
        {
            //若存在上级下拉框
            if (_curSelect.previousSibling)
            {
                //取值为上级下拉框选中值
                this.storeValueObj.value = this.getMyValue(_curSelect.previousSibling.options[_curSelect.previousSibling.selectedIndex].value);
            }
            else
            {
                //没上级则取值为0
                this.storeValueObj.value = this.getMyValue(0);
            }
            //选择第一项(请选择...),没有下级选项,所以要返回
            return false;
        }
        //选择的不是第一项
        this.storeValueObj.value = this.getMyValue(_iValue);

        //去掉当前下拉框原来的选择状态
        //将选中的选项对应代码更改为 selected
        for (i=0;i<_curSelect.options.length;i++)
        {
            if (_curSelect.options[i].selected=="selected")
            {
                _curSelect.options[i].removeAttribute("selected");
            }
            if (_curSelect.options[i].value==_iValue)
            {
                _curSelect.options[i].selected="selected";
            }
        }
        //新生成的下级下拉列表
        _hasChild=false;
		var j=1;
        for (var i = 0; i < this.sortArr.length; i++)
        {
			//
            if (this.sortArr[i][2] == _iValue)
            {
                if (_hasChild==false)
                {
                    _siblingSelect=document.createElement("select");
                    this.showSelectObj.insertAdjacentElement("beforeEnd",_siblingSelect);
                    _siblingSelect.sortMenuObj=_sortMenuObj;
                    _siblingSelect.onchange=function()
                    {
                        this.sortMenuObj.setSorts(this,this.sortMenuObj);
                    }
					//alert(i);
					 _siblingSelect.options[0] =  new Option("==请选择==",""); //--修改
                   // _siblingSelect.add(new Option("请选择...",""));
				     _siblingSelect.options[j] =  new Option(this.sortArr[i][1],this.sortArr[i][0]); //--修改
                  //  _siblingSelect.add(new Option(this.sortArr[i][1],this.sortArr[i][0]));
                    _hasChild=true;
                }
                else
                {
                   // _siblingSelect.add(new Option(this.sortArr[i][1],this.sortArr[i][0]));
					_siblingSelect.options[j] =  new Option(this.sortArr[i][1],this.sortArr[i][0]); //--修改
                }
				j++;
            }
		
        }
    }

    /**
     * 根据最小类选取值生成整个联动菜单,由后往前递归完成
     * _minCataValue:最小类的取值
     * _sortMenuObj:sortMenu的实例对象，指向自己
     */
    this.newInit=function(_minCataValue,_sortMenuObj)
    {
        if (this.storeValueObj.value=="undefined" || this.storeValueObj.value=="")
        {
            this.storeValueObj.value=this.getMyValue(_minCataValue);
        }
        if (_minCataValue == 0)
        {
            //minCataValue为0，也就是初始化了
            this.initSorts(_sortMenuObj);
            //初始化完成后，退出函数
            return false;
        }
        //父级ID
        _parentID=null;
        _select=document.createElement("select");
        _select.sortMenuObj=_sortMenuObj;
        _select.onchange=function()
        {
            this.sortMenuObj.setSorts(this,this.sortMenuObj);
        }
        this.showSelectObj.insertAdjacentElement('afterBegin',_select);
		_select.options[0] =  new Option("==请选择==",""); //--修改
       // _select.add(new Option("请选择...",""));
        for (var i = 0; i < this.sortArr.length; i++)
        {
            if (_minCataValue == this.sortArr[i][0])
            {
                _parentID = this.sortArr[i][2];
                break;
            }
        }
		var j=1;
        for (var i = 0; i < this.sortArr.length; i++)
        {
            if (this.sortArr[i][2] == _parentID)
            {
                if (this.sortArr[i][0] == _minCataValue)
                {
					//alert(this.sortArr[i][1]);
					_select.options[j] =  new Option(this.sortArr[i][1],this.sortArr[i][0]); //--修改
                   // _opt=new Option(this.sortArr[i][1],this.sortArr[i][0]);
                    //_select.add(_opt);
					//alert(this.sortArr.length);
                    _select.options[j].selected="selected";
                }
                else
                {
					_select.options[j] =  new Option(this.sortArr[i][1],this.sortArr[i][0]);
                   // _select.add(new Option(this.sortArr[i][1],this.sortArr[i][0]));
                }
				j++
            }
        }
        if (_parentID > 0)
        {
            this.newInit(_parentID,_sortMenuObj);
        }
    }
    this.getMyValue=function(_id) {
        if (_id==0) return "";
        var _temp;
        for (var i=0;i<this .sortArr.length;i++) {
            _temp=this.sortArr[i];
            if (_temp[0]==_id) return _temp[3];
        }
    }
}