package com.melardev.spring.twitterapi.dtos.response.admin;

import com.melardev.spring.twitterapi.dtos.PageMeta;
import com.melardev.spring.twitterapi.dtos.response.SuccessResponse;
import com.melardev.spring.twitterapi.dtos.response.users.UserDto;

import java.util.Collection;

public class UsersDataSection extends SuccessResponse {
    private Collection<UserDto> users;
    private PageMeta pageMeta;

    public Collection<UserDto> getUsers() {
        return users;
    }

    public PageMeta getPageMeta() {
        return pageMeta;
    }

    public void setPageMeta(PageMeta pageMeta) {
        this.pageMeta = pageMeta;
    }

    public void setUsers(Collection<UserDto> usersDto) {
        this.users = usersDto;
    }

    public void setMeta(PageMeta pageMeta) {
        this.pageMeta = pageMeta;
    }
}
