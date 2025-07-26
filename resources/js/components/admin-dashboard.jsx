import { useEffect, useState } from "react";
import { Box, Grid, Text, Flex, Heading, Table, Button } from "@radix-ui/themes";

export default function AdminDashboard() {
  const [stats, setStats] = useState({
    users: null,
    posts: null,
    comments: null,
    blockedComments: null,
  });

  useEffect(() => {
    fetch("/admin/stats")
      .then((res) => res.json())
      .then((data) => setStats(data));
  }, []);

  const [posts, setPosts] = useState([]);

  useEffect(() => {
    fetch("/admin/posts")
      .then((res) => res.json())
      .then((data) => setPosts(data));
  }, []);

  // Navigation helpers
  const goTo = (url) => window.location.href = url;

  // Delete handler
  const handleDelete = async (id) => {
    if (!window.confirm("Are you sure you want to delete this post?")) return;
    const res = await fetch(`/blog/${id}`, {
      method: "DELETE",
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "",
        "Accept": "application/json",
      }
    });
    if (res.ok) {
      setPosts(posts.filter(p => p.id !== id));
    } else {
      alert("Failed to delete post.");
    }
  };

  return (
    <>
      <Heading mb="5">Dashboard</Heading>
      <Grid columns={{ initial: "1", md: "2", lg: "4" }} gap="4" mb="5">
        <Box className="bg-[#ffe09f] rounded-xl border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-6 shadow min-h-32">
          <Flex direction="column" align="center" justify="center" gap="4" style={{ minHeight: "100%" }}>
            <Text size="3" weight="bold" >Users</Text>
            <Text size="7" weight="bold">{stats.users ?? "—"}</Text>
          </Flex>
        </Box>
        <Box className="bg-[#ffe09f] rounded-xl border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-6 shadow min-h-32">
          <Flex direction="column" align="center" justify="center" gap="4" style={{ minHeight: "100%" }}>
            <Text size="3" weight="bold">Posts</Text>
            <Text size="7" weight="bold">{stats.posts ?? "—"}</Text>
          </Flex>
        </Box>
        <Box className="bg-[#ffe09f] rounded-xl border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-6 shadow min-h-32">
          <Flex direction="column" align="center" justify="center" gap="4" style={{ minHeight: "100%" }}>
            <Text size="3" weight="bold">Comments</Text>
            <Text size="7" weight="bold">{stats.comments ?? "—"}</Text>
          </Flex>
        </Box>
        <Box className="bg-[#ffe09f] rounded-xl border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-6 shadow min-h-32">
          <Flex direction="column" align="center" justify="center" gap="4" style={{ minHeight: "100%" }}>
            <Text size="3" weight="bold">Blocked Comments</Text>
            {/* <Text size="7" weight="bold">{stats.blockedComments ?? "—"}</Text> */}
          </Flex>
        </Box>
      </Grid>
      <Table.Root className="bg-white rounded-xl border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e]">
        <Table.Header>
          <Table.Row>
            <Table.ColumnHeaderCell className="w-[60px]">ID</Table.ColumnHeaderCell>
            <Table.ColumnHeaderCell className="truncate max-w-0">Title</Table.ColumnHeaderCell>
            <Table.ColumnHeaderCell className="w-[60px]">Likes</Table.ColumnHeaderCell>
            <Table.ColumnHeaderCell className="w-[210px]">Actions</Table.ColumnHeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {posts.map((post) => (
            <Table.Row key={post.id}>
              <Table.Cell>{post.id}</Table.Cell>
              <Table.Cell>{post.title}</Table.Cell>
              <Table.Cell>{post.like_count ?? 0}</Table.Cell>
              <Table.Cell>
                <Flex gap="2">
                  <Button size="1" color="blue" variant="soft" onClick={() => goTo(`/blog/${post.id}`)}>
                    Read More
                  </Button>
                  <Button size="1" color="orange" variant="soft" onClick={() => goTo(`/blog/${post.id}/edit`)}>
                    Edit
                  </Button>
                  <Button size="1" color="red" variant="soft" onClick={() => handleDelete(post.id)}>
                    Delete
                  </Button>
                </Flex>
              </Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table.Root>
    </>
  );
}