import { useEffect, useState } from "react";
import { Box, Table, Text, Heading, Flex, Button, SegmentedControl } from "@radix-ui/themes";

export default function AdminUsers() {
  const [users, setUsers] = useState([]);
  const [usersLoading, setUsersLoading] = useState(true);
  const [usersError, setUsersError] = useState(null);

  useEffect(() => {
    fetch("/admin/users/data")
      .then((res) => {
        if (!res.ok) throw new Error("Failed to fetch users");
        return res.json();
      })
      .then((data) => {
        setUsers(data);
        setUsersError(null);
      })
      .catch((e) => setUsersError(e.message))
      .finally(() => setUsersLoading(false));
  }, []);

  const handleUserTypeChange = async (userId, newType) => {
    const res = await fetch(`/admin/users/${userId}/type`, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "",
        "Accept": "application/json",
      },
      body: JSON.stringify({ user_type: newType })
    });
    if (res.ok) {
      setUsers(users.map(u => u.id === userId ? { ...u, user_type: newType } : u));
    } else {
      alert("Failed to update user type");
    }
  };

  const handleBanToggle = async (userId, isBanned) => {
    const res = await fetch(`/admin/users/${userId}/ban`, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "",
        "Accept": "application/json",
      },
      body: JSON.stringify({ is_banned: !isBanned ? 1 : 0 })
    });
    if (res.ok) {
      setUsers(users.map(u => u.id === userId ? { ...u, is_banned: !isBanned } : u));
    } else {
      alert("Failed to update ban status");
    }
  };

  return (
    <Box style={{ backgroundColor: '#ccdee8', height: "100vh", overflowY: "auto", fontFamily: "Geist, sans-serif" }}>
        <Flex align="center" justify="between" mb="5" mt="8">
          <Heading>Users</Heading>
          <Button>
            <a href="/register">Add User</a>
          </Button>
        </Flex>
        {usersLoading ? (
        <Text>Loading users...</Text>
      ) : usersError ? (
        <Text color="red">{usersError}</Text>
      ) : (
        <Table.Root variant="surface" mt="5">
          <Table.Header>
            <Table.Row>
              <Table.ColumnHeaderCell>ID</Table.ColumnHeaderCell>
              <Table.ColumnHeaderCell>Username</Table.ColumnHeaderCell>
              <Table.ColumnHeaderCell>Full Name</Table.ColumnHeaderCell>
              <Table.ColumnHeaderCell>Email</Table.ColumnHeaderCell>
              <Table.ColumnHeaderCell>User Type</Table.ColumnHeaderCell>
              <Table.ColumnHeaderCell>Is Banned?</Table.ColumnHeaderCell>
              <Table.ColumnHeaderCell>Actions</Table.ColumnHeaderCell>
            </Table.Row>
          </Table.Header>
          <Table.Body>
            {users.length === 0 ? (
              <Table.Row>
                <Table.Cell colSpan={7} align="center">No users found.</Table.Cell>
              </Table.Row>
            ) : users.map((user) => (
              <Table.Row key={user.id}>
                <Table.Cell>{user.id}</Table.Cell>
                <Table.Cell>{user.username}</Table.Cell>
                <Table.Cell>{user.full_name}</Table.Cell>
                <Table.Cell>{user.email}</Table.Cell>
                <Table.Cell>
                  <SegmentedControl.Root
                    size="1"
                    value={user.user_type}
                    onValueChange={val => handleUserTypeChange(user.id, val)}
                  >
                    <SegmentedControl.Item value="admin">Admin</SegmentedControl.Item>
                    <SegmentedControl.Item value="subscriber">Subscriber</SegmentedControl.Item>
                  </SegmentedControl.Root>
                </Table.Cell>
                <Table.Cell>
                  <Text color={user.is_banned ? "red" : "green"}>
                    {user.is_banned ? "Yes" : "No"}
                  </Text>
                </Table.Cell>
                <Table.Cell>
                  <Button
                    size="1"
                    color={user.is_banned ? "green" : "red"}
                    variant="soft"
                    onClick={() => handleBanToggle(user.id, user.is_banned)}
                  >
                    {user.is_banned ? "Unban" : "Ban"}
                  </Button>
                </Table.Cell>
              </Table.Row>
            ))}
          </Table.Body>
        </Table.Root>
      )}
    </Box>
  );
}