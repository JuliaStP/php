hw-5: schema
    + tables
        messages: table
            + columns
                id: int NN identity null
                user_id: int NN
                text: text
                date: datetime NN
                image: varchar(255)
            + indices
                user_ndx: index (user_id) type btree
            + keys
                #1: PK (id)
        users: table
            + columns
                id: int NN identity null
                username: varchar(255) NN
                date: datetime NN
                email: varchar(255) NN
                password: varchar(255) NN
            + keys
                #1: PK (id)
